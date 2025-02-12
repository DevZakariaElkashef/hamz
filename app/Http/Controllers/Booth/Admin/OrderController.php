<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Http\Services\FirebaseService;
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
use App\Models\User;

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
        $orderStatuses = OrderStatus::active()->get();
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
        $order = Order::findOrFail($request->id);
        $oldOrderStatusId = $order->order_status_id;
        $user = null;
        $order->update(['order_status_id' => $request->status_id]);
        if ($order->payment_status == '1') {
            if ($order->order_status_id == '4' && $oldOrderStatusId != '4') {
                // Add Order Total To Store Owner
                $user = User::select('users.*')
                    ->join('stores', 'stores.user_id', '=', 'users.id')
                    ->join('orders', 'orders.store_id', '=', 'stores.id')
                    ->where('orders.id', $request->id)
                    ->first();

                $user->update([
                    'wallet' => $user->wallet + ($order->total - $order->total / 100 * $order->management_ratio)
                ]);
            } else if ($order->order_status_id != '4' && $oldOrderStatusId == '4') {
                // Remove Order Total To Store Owner If Order Finished Before
                $user = User::select('users.*')
                    ->join('stores', 'stores.user_id', '=', 'users.id')
                    ->join('orders', 'orders.store_id', '=', 'stores.id')
                    ->where('orders.id', $request->id)
                    ->first();

                $user->update([
                    'wallet' => $user->wallet - ($order->total - $order->total / 100 * $order->management_ratio)
                ]);
            }

            // Remove Order Total From User If Order Cancelled Before
            if ($order->order_status_id != '5' && $oldOrderStatusId == '5') {
                $user = User::findOrFail($order->user_id);
                $user->update([
                    'wallet' => $user->wallet - $order->total
                ]);
            } elseif ($order->order_status_id == '5' && $oldOrderStatusId != '5') {
                // Add Order Total To User If Order Finished Before
                $user = User::findOrFail($order->user_id);
                $user->update([
                    'wallet' => $user->wallet + $order->total
                ]);
            }
        }
        if($user->device_token)
        {
            $firebase = new FirebaseService();
            $firebase->notify("الطلب رقم #$order->id", ".تم تغير حاله طلبكم الان ".$order->orderStatus->name, $user->device_token);
        }
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
