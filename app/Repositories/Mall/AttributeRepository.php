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

        if ($request->filled('start_at')) {
            $attributes->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $attributes->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('is_active')) {
            $attributes->where('is_active', $request->is_active);
        }

        $attributes = $attributes->mall()->paginate($this->limit);

        return $attributes;
    }


    public function search($request)
    {
        return Attribute::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        return Attribute::create($data);
    }


    public function update($request, $attribute)
    {
        $data = $request->all();
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