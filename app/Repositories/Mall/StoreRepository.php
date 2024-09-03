<?php

namespace App\Repositories\Mall;

use App\Models\Store;
use App\Traits\ImageUploadTrait;

class StoreRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $stores = Store::query();

        if ($request->filled('start_at')) {
            $stores->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $stores->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('section_id')) {
            $stores->where('section_id', $request->section_id);
        }

        if ($request->filled('is_active')) {
            $stores->where('is_active', $request->is_active);
        }

        $stores = $stores->mall()->with('section')->paginate($request->per_page ?? $this->limit);

        return $stores;
    }


    public function search($request)
    {
        return Store::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'stores');
        }

        $data['appp'] = 'mall';

        $store = Store::create($data);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $store->images()->create([
                    'path' => $this->uploadImage($image, 'stores')
                ]);
            }
        }

        return $store;
    }


    public function update($request, $store)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'stores', $store->image);
        }


        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $store->images()->create([
                    'path' => $this->uploadImage($image, 'stores')
                ]);
            }
        }

        if (!$request->has('delivery_type')) {
            $store->update(['delivery_type' => 0]);
        }

        if (!$request->has('pick_up')) {
            $store->update(['pick_up' => 0]);
        }

        $store->update($data);

        return $store;
    }


    public function delete($store)
    {
        $store->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Store::whereIn('id', $ids)->delete();
        return true;
    }
}
