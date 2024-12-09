<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Store;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Exports\Mall\CouponExport;
use App\Imports\Mall\CouponImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\CouponRepository;
use App\Http\Requests\Mall\Web\CouponRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class CouponController extends Controller
{
    protected $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;

        // autherization
        $this->middleware('can:mall.coupons.index')->only('index');
        $this->middleware('can:mall.coupons.create')->only(['create', 'store']);
        $this->middleware('can:mall.coupons.update')->only(['edit', 'update']);
        $this->middleware('can:mall.coupons.delete')->only('destroy');
        $this->middleware('can:mall.coupons.export')->only('export');
        $this->middleware('can:mall.coupons.import')->only('import');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupons = $this->couponRepository->index($request);
        return view('mall.coupons.index', compact('coupons'));
    }

    public function search(Request $request)
    {
        $coupons = $this->couponRepository->search($request);
        return view('mall.coupons.table', compact('coupons'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new CouponExport($request), 'coupons.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new CouponImport, $request->file('file'));

            return back()->with('success', __("main.created_successfully"));
        } catch (ValidationException $e) {
            // Get the first failure from the exception
            $failure = $e->failures()[0];

            // Format the error message for the first failed row
            $errorMessage = "Row {$failure->row()}: " . implode(', ', $failure->errors());

            // Flash the error message to the session
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Handle any other exceptions that might occur
            return back()->with('error', __("An unexpected error occurred: " . $e->getMessage()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::mall()->active()->get();
        return view("mall.coupons.create", compact('stores'));
    }

    /**
     * Coupon a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $this->couponRepository->coupon($request); // coupon coupon
        return to_route('mall.coupons.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.coupons.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('mall.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $this->couponRepository->update($request, $coupon);
        return to_route('mall.coupons.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Coupon $coupon)
    {
        $coupon->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->couponRepository->delete($coupon);
        return to_route('mall.coupons.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->couponRepository->deleteSelection($request);
        return to_route('mall.coupons.index')->with('success', __("main.delete_successffully"));
    }
}
