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
        return to_route('mall.orders.index')->with('success', __("mall.created_successffully"));
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
                'name' => __("mall.pending")
            ],
            [
                'id' => 1,
                'name' => __("mall.paid")
            ],
            [
                'id' => 2,
                'name' => __("mall.faild")
            ]
        ];

        return view('mall.orders.show', compact('order', 'orderStatuses', 'paymentStatus', 'products'));
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
        return to_route('mall.orders.index')->with('success', __("mall.updated_successffully"));
    }

    public function toggleStatus(Request $request, Order $order)
    {
        $order->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("mall.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderRepository->delete($order);
        return to_route('mall.orders.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->orderRepository->deleteSelection($request);
        return to_route('mall.orders.index')->with('success', __("mall.delete_successffully"));
    }
}
