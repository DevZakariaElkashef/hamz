<?php

namespace App\Repositories;

use App\Models\Application;
use App\Traits\ImageUploadTrait;

class ApplicationRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $applications = Application::where('id', '!=', 1)->paginate($request->per_page ?? $this->limit);

        return $applications;
    }

    public function search($request)
    {
        return Application::where('id', '!=', 1)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadImage($request->file('logo'), 'applications');
        }
        unset($data['_token']);
        $application = Application::create($data);

        if ($application->is_fixed) {
            $this->updateOtherApplications($application->id);
        }

        return $application;
    }

    public function update($request, $application)
    {
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadImage($request->file('logo'), 'applications', $application->logo);
        }
        unset($data['_token'], $data['_method']);
        $application->update($data);

        if ($application->is_fixed) {
            $this->updateOtherApplications($application->id);
        }

        return $application;
    }

    public function updateOtherApplications(int $currentApplicationId): void
    {
        Application::whereNot('id', $currentApplicationId)->update(['is_fixed' => 0]);
    }

    public function delete($application)
    {
        if ($application->image) {
            $this->deleteImage($application->image);
        }

        $application->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Application::whereIn('id', $ids)->delete();
        return true;
    }
}
