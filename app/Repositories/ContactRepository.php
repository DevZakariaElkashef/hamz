<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Traits\ImageUploadTrait;

class ContactRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $contacts = Contact::with('contactType')->filter($request)->paginate($request->per_page ?? $this->limit);

        return $contacts;
    }


    public function search($request)
    {
        return Contact::search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        $data['app'] = 'all';
        unset($data['_token']);
        return Contact::create($data);
    }


    public function update($request, $contact)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $contact->update($data);
        return $contact;
    }


    public function delete($contact)
    {
        $contact->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Contact::whereIn('id', $ids)->delete();
        return true;
    }
}
