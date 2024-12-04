<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\Role;
use App\Traits\ImageUploadTrait;

class RoleRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $roles = Role::filter($request)->whereNotIn('id', [1, 2, 3])->paginate($request->per_page ?? $this->limit);

        return $roles;
    }

    public function cities()
    {
        $cities = City::active()->get();

        return $cities;
    }

    public function search($request)
    {
        return Role::whereNotIn('id', [1, 2, 3])->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'roles');
        }
        $data['role_id'] = 4;
        unset($data['_token']);
        return Role::create($data);
    }

    public function update($request, $role)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'roles', $role->image);
        }
        unset($data['_token'], $data['_method'], $data['id']);
        if (!$data['password']) {
            unset($data['password']);
        }
        $role->update($data);
        return $role;
    }

    public function delete($role)
    {
        $role->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Role::whereIn('id', $ids)->delete();
        return true;
    }
}
