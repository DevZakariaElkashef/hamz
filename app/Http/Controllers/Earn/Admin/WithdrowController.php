<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Models\Withdrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Earn\WithdrowRepository;

class WithdrowController extends Controller
{
    protected $withdrowRepository;

    public function __construct(WithdrowRepository $withdrowRepository)
    {
        $this->withdrowRepository = $withdrowRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdrows = $this->withdrowRepository->index($request);
        return view('earn.withdrows.index', compact('withdrows'));
    }

    public function search(Request $request)
    {
        $withdrows = $this->withdrowRepository->search($request);
        return view('earn.withdrows.table', compact('withdrows'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.withdrows.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdrow $withdrow)
    {
        return view('earn.withdrows.edit', compact('withdrow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdrow $withdrow)
    {
        $this->withdrowRepository->update($request, $withdrow);
        return to_route('earn.withdrows.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Withdrow $withdrow)
    {
        $withdrow->update(['status' => $request->status]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrow $withdrow)
    {
        $this->withdrowRepository->delete($withdrow);
        return to_route('earn.withdrows.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->withdrowRepository->deleteSelection($request);
        return to_route('earn.withdrows.index')->with('success', __("main.delete_successffully"));
    }
}
