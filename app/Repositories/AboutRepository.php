<?php

namespace App\Repositories;

use App\Models\About;
use App\Traits\ImageUploadTrait;

class AboutRepository
{
    use ImageUploadTrait;

    public function index()
    {
        $about = About::first();

        return $about;
    }

    public function update($request, $about)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $about->update($data);
        return $about;
    }
}
