<?php

namespace App\Repositories\Mall;

use App\Models\Attribute;
use App\Traits\ImageUploadTrait;

class AttributeRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $attributes = Attribute::query();

        if ($request->user()->role_id == 3) {
            $attributes = $attributes->where('store_id', $request->user()->store->id);
        }

        $attributes = $attributes->filter($request)->mall()->paginate($request->per_page ?? $this->limit);

        return $attributes;
    }


    public function search($request)
    {
        return Attribute::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->all();

        if ($request->user()->role_id == 3) {
            $data['store_id'] = $request->user()->store->id;
        }
        $data['app'] = 'mall';
        
        unset($data['_token']);
        return Attribute::create($data);
    }


    public function update($request, $attribute)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $attribute->update($data);
        return $attribute;
    }


    public function delete($attribute)
    {
        $attribute->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Attribute::whereIn('id', $ids)->delete();
        return true;
    }
}
