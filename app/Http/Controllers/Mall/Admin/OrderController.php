<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Exports\Mall\OrderExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\OrderRepository;
use App\Http\Requests\Mall\Web\OrderRequest;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->index($request);
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        $brands = Brand::mall()->active()->get();
        return view('mall.orders.index', compact('orders', 'sections', 'stores', 'brands', 'categories'));
    }

    public function search(Request $request)
    {
        $orders = $this->orderRepository->search($request);
        return view('mall.orders.table', compact('orders'))->render();
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
        return view("mall.orders.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $this->orderRepository->store($request); // store order
        return to_route('mall.orders.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderStatuses = OrderStatus::mall()->active()->get();
        $products = Product::mall()->active()->get();
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

        return view('mall.orders.show', compact('order', 'orderStatuses', 'paymentStatus', 'products', 'paymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('mall.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this->orderRepository->update($request, $order);
        return to_route('mall.orders.index')->with('success', __("main.updated_successffully"));
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
        return to_route('mall.orders.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->orderRepository->deleteSelection($request);
        return to_route('mall.orders.index')->with('success', __("main.delete_successffully"));
    }
}