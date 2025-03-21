<?php

namespace App\Repositories;

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
        $cities = City::filter($request)->paginate($request->per_page ?? $this->limit);

        return $cities;
    }


    public function search($request)
    {
        return City::search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'cities');
        }
        unset($data['_token']);
        return City::create($data);
    }


    public function update($request, $city)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'cities', $city->image);
        }
        unset($data['_token'], $data['_method']);
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
