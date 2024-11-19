<?php

namespace App\Repositories;

use App\Models\Application;
use App\Traits\ImageUploadTrait;

class SettingRepository
{
    use ImageUploadTrait;

    public function index()
    {
        $application = Application::first();

        return $application;
    }

    public function update($request, $application)
    {
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $data['logo'] =  $this->uploadImage($request->file('logo'), 'applications', $application->logo);
        }
        unset($data['_token'], $data['_method']);
        $application->update($data);
        return $application;
    }
}
