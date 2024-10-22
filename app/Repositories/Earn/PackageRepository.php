<?php

namespace App\Repositories\Earn;

use App\Models\Package;
use App\Traits\ImageUploadTrait;

class PackageRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $packages = Package::filter($request)->earn()->paginate($request->per_page ?? $this->limit);

        return $packages;
    }


    public function search($request)
    {
        return Package::earn()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        $data['color'] = fake()->hexColor();
        $data['app'] = 'earn';
        unset($data['_token']);
        return Package::create($data);
    }


    public function update($request, $package)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'packages', $package->image);
        }
        unset($data['_token'], $data['_method']);
        $package->update($data);
        return $package;
    }


    public function delete($package)
    {
        $package->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Package::whereIn('id', $ids)->delete();
        return true;
    }
}
