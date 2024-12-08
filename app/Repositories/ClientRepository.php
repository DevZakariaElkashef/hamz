<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;
use App\Traits\ImageUploadTrait;

class ClientRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $clients = User::filter($request)->where('role_id', 2)->paginate($request->per_page ?? $this->limit);

        return $clients;
    }

    public function cities()
    {
        $cities = City::active()->get();

        return $cities;
    }

    public function search($request)
    {
        return User::where('role_id', 2)->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'clients');
        }
        $data['role_id'] = 2;
        unset($data['_token']);
        return User::create($data);
    }

    public function update($request, $client)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'clients', $client->image);
        }
        unset($data['_token'], $data['_method'], $data['id']);
        if (!$data['password']) {
            unset($data['password']);
        }
        $client->update($data);
        return $client;
    }

    public function delete($client)
    {
        if ($client->image) {
            $this->deleteImage($client->image);
        }
        
        $client->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)->delete();
        return true;
    }
}
