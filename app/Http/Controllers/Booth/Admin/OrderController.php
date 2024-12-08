<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Exports\Booth\OrderExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Booth\OrderRepository;
use App\Http\Requests\Booth\Web\OrderRequest;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('can:booth.orders.index')->only(['index']);
        $this->middleware('can:booth.orders.create')->only(['create', 'store']);
        $this->middleware('can:booth.orders.update')->only(['edit', 'update']);
        $this->middleware('can:booth.orders.delete')->only(['destroy']);

        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->index($request);
        $sections = Section::booth()->active()->get();
        $stores = Store::booth()->active()->get();
        $categories = Category::booth()->active()->get();
        $brands = Brand::booth()->active()->get();
        return view('booth.orders.index', compact('orders', 'sections', 'stores', 'brands', 'categories'));
    }

    public function search(Request $request)
    {
        $orders = $this->orderRepository->search($request);
        return view('booth.orders.table', compact('orders'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new OrderExport($request), 'orders.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("booth.orders.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $this->orderRepository->store($request); // store order
        return to_route('booth.orders.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderStatuses = OrderStatus::booth()->active()->get();
        $products = Product::booth()->active()->get();
        $paymentStatus = [
            [
                'id' => 0,
                'name' => __("main.pending")
            ],
            [
                'id' => 1,
                'name' => __("main.paid")
            ],
            [
                'id' => 2,
                'name' => __("main.faild")
            ]
        ];

        $paymentMethods = [
            [
                'id' => 0,
                'name' => __('main.online')
            ],
            [
                'id' => 1,
                'name' => __('main.wallet')
            ]
        ];

        return view('booth.orders.show', compact('order', 'orderStatuses', 'paymentStatus', 'products', 'paymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('booth.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this->orderRepository->update($request, $order);
        return to_route('booth.orders.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Order $order)
    {
        $order->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    public function updateStatus(Request $request)
    {
        Order::findOrFail($request->id)->update(['order_status_id' => $request->status_id]);

        return back()->with('success', __("main.updated_successffully"));
    }

    public function updatePayment(Request $request)
    {
        Order::findOrFail($request->id)->update([
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', __("main.updated_successffully"));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderRepository->delete($order);
        return to_route('booth.orders.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->orderRepository->deleteSelection($request);
        return to_route('booth.orders.index')->with('success', __("main.delete_successffully"));
    }
}
