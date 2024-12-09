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
        $option = Option::checkVendor($request->user())->filter($request)->mall()->paginate($request->per_page ?? $this->limit);

        return $option;
    }


    public function search($request)
    {
        return Option::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['app'] = 'mall';

        if ($request->user()->role_id == 3) {
            $data['store_id'] = $request->user()->store->id;
        }

        unset($data['_token']);
        return Option::create($data);
    }


    public function update($request, $option)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
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
