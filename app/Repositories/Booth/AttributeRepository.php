<?php

namespace App\Repositories\Booth;

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
        $attributes = Attribute::filter($request)->booth()->paginate($request->per_page ?? $this->limit);

        return $attributes;
    }


    public function search($request)
    {
        return Attribute::booth()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['app'] = 'booth';
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
