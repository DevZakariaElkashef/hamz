<?php

namespace App\Repositories\Mall;

use App\Models\Order;
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
        $order = Order::checkVendor($request->user())->filter($request)->mall()->paginate($request->per_page ?? $this->limit);

        return $order;
    }


    public function search($request)
    {
        return Order::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
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
