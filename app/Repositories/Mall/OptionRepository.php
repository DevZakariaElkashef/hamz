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
        $option = Option::query();

        if ($request->filled('start_at')) {
            $option->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $option->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('is_active')) {
            $option->where('is_active', $request->is_active);
        }

        $option = $option->mall()->paginate($this->limit);

        return $option;
    }


    public function search($request)
    {
        return Option::mall()->search($request->search)->paginate($this->limit);
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
