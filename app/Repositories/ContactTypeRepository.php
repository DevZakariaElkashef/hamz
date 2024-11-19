<?php

namespace App\Repositories;

use App\Models\contactType;
use App\Traits\ImageUploadTrait;

class ContactTypeRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $contactTypes = contactType::filter($request)->paginate($request->per_page ?? $this->limit);

        return $contactTypes;
    }


    public function search($request)
    {
        return contactType::search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        unset($data['_token']);
        return contactType::create($data);
    }


    public function update($request, $contactType)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $contactType->update($data);
        return $contactType;
    }


    public function delete($contactType)
    {
        $contactType->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        contactType::whereIn('id', $ids)->delete();
        return true;
    }
}
