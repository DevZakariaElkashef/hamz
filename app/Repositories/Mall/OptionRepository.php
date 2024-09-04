<?php

namespace App\Repositories\Mall;

use App\Models\Option;
use App\Traits\ImageUploadTrait;

class OptionRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $option = Option::filter($request)->mall()->paginate($request->per_page ?? $this->limit);

        return $option;
    }


    public function search($request)
    {
        return Option::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        return Option::create($data);
    }


    public function update($request, $option)
    {
        $data = $request->all();
        $option->update($data);
        return $option;
    }


    public function delete($option)
    {
        $option->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Option::whereIn('id', $ids)->delete();
        return true;
    }
}
