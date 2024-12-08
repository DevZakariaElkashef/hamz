<?php

namespace App\Repositories\Booth;

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
        $stores = Store::filter($request)->booth()->with('section')->paginate($request->per_page ?? $this->limit);

        return $stores;
    }


    public function search($request)
    {
        return Store::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'stores');
        }

        $data['appp'] = 'booth';
        unset($data['_token']);
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
        unset($data['_token'], $data['_method']);
        $store->update($data);

        return $store;
    }


    public function delete($store)
    {
        if ($store->image) {
            $this->deleteImage($store->image);
        }

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
