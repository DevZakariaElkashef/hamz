<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;
use App\Traits\ImageUploadTrait;

class EmployeeRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $employees = User::filter($request)->whereNotIn('role_id', [1, 2, 3])->paginate($request->per_page ?? $this->limit);

        return $employees;
    }

    public function cities()
    {
        $cities = City::active()->get();

        return $cities;
    }

    public function search($request)
    {
        return User::whereNotIn('role_id', [1, 2, 3])->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'employees');
        }
        $data['role_id'] = 4;
        unset($data['_token']);
        return User::create($data);
    }

    public function update($request, $employee)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'employees', $employee->image);
        }
        unset($data['_token'], $data['_method'], $data['id']);
        if (!$data['password']) {
            unset($data['password']);
        }
        $employee->update($data);
        return $employee;
    }

    public function delete($employee)
    {
        if ($employee->image) {
            $this->deleteImage($employee->image);
        }

        $employee->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)->delete();
        return true;
    }
}
