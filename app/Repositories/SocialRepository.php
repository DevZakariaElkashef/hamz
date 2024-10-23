<?php

namespace App\Repositories;

use App\Models\Social;
use App\Traits\ImageUploadTrait;

class SocialRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $socials = Social::filter($request)->paginate($request->per_page ?? $this->limit);

        return $socials;
    }


    public function search($request)
    {
        return Social::paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('icon');
        if ($request->hasFile('icon')) {
            $data['icon'] =  $this->uploadImage($request->file('icon'), 'socials');
        }
        unset($data['_token']);
        return Social::create($data);
    }


    public function update($request, $social)
    {
        $data = $request->except('icon');
        if ($request->hasFile('icon')) {
            $data['icon'] =  $this->uploadImage($request->file('icon'), 'socials', $social->icon);
        }
        unset($data['_token'], $data['_method']);
        $social->update($data);
        return $social;
    }


    public function delete($social)
    {
        $social->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Social::whereIn('id', $ids)->delete();
        return true;
    }
}
