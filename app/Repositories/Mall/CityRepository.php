<?php

namespace App\Repositories\Mall;

use App\Models\City;
use App\Traits\ImageUploadTrait;

class CityRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $cities = City::query();

        if ($request->filled('start_at')) {
            $cities->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $cities->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('is_active')) {
            $cities->where('is_active', $request->is_active);
        }

        $cities = $cities->mall()->paginate($this->limit);

        return $cities;
    }


    public function search($request)
    {
        return City::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'cities');
        }
        return City::create($data);
    }


    public function update($request, $city)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'cities', $city->image);
        }
        $city->update($data);
        return $city;
    }


    public function delete($city)
    {
        $city->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        City::whereIn('id', $ids)->delete();
        return true;
    }
}
