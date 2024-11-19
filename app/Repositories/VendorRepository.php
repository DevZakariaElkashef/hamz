<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;
use App\Traits\ImageUploadTrait;

class VendorRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $vendors = User::filter($request)->where('role_id', 3)->paginate($request->per_page ?? $this->limit);

        return $vendors;
    }

    public function cities()
    {
        $cities = City::active()->get();

        return $cities;
    }

    public function search($request)
    {
        return User::where('role_id', 3)->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'vendors');
        }
        $data['role_id'] = 3;
        unset($data['_token']);
        return User::create($data);
    }

    public function update($request, $vendor)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'vendors', $vendor->image);
        }
        unset($data['_token'], $data['_method'], $data['id']);
        if (!$data['password']) {
            unset($data['password']);
        }
        $vendor->update($data);
        return $vendor;
    }

    public function delete($vendor)
    {
        $vendor->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)->delete();
        return true;
    }
}
