<?php

namespace App\Repositories\Booth;

use App\Models\Order;
use App\Models\Store;
use App\Traits\ImageUploadTrait;

class OrderRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $order = Order::filter($request)->booth();
        if ($request->user()->role->name == 'seller') {
            $store = Store::booth()->active()->where('user_id', $request->user()->id)->first();
            $storeId = '';
            if ($store) {
                $storeId = $store->id;
            }
            $order = $order->checkVendor($storeId);
        }
        $order = $order->paginate($request->per_page ?? $this->limit);
        return $order;
    }


    public function search($request)
    {
        return Order::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        return Order::create($data);
    }


    public function update($request, $order)
    {
        $data = $request->all();
        $order->update($data);
        return $order;
    }


    public function delete($order)
    {
        $order->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Order::whereIn('id', $ids)->delete();
        return true;
    }
}
