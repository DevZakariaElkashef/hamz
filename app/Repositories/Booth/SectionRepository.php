<?php

namespace App\Repositories\Booth;

use App\Models\Section;
use App\Traits\ImageUploadTrait;

class SectionRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $sections = Section::filter($request)->booth()->paginate($request->per_page ?? $this->limit);

        return $sections;
    }


    public function search($request)
    {
        return Section::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sections');
        }
        $data['app'] = 'booth';
        unset($data['_token']);
        return Section::create($data);
    }


    public function update($request, $section)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sections', $section->image);
        }
        unset($data['_token'], $data['_method']);
        $section->update($data);

        return $section;
    }


    public function delete($section)
    {
        $section->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Section::whereIn('id', $ids)->delete();
        return true;
    }
}
