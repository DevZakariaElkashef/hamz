<?php

namespace App\Repositories\Booth;

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
        $option = Option::filter($request)->booth()->paginate($request->per_page ?? $this->limit);

        return $option;
    }


    public function search($request)
    {
        return Option::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['app'] = 'booth';
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
