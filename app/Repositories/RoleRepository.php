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

    public function search($request)
    {
        return Role::whereNotIn('id', [1, 2, 3])->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        unset($data['_token']);
        return Role::create($data);
    }

    public function update($request, $role)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method'], $data['id']);

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
