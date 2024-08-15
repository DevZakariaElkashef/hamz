<?php

namespace App\Repositories\Mall;

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
        $sections = Section::query();

        if ($request->filled('start_at')) {
            $sections->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $sections->whereDate('created_at', '<=', $request->end_at);
        }

        $sections = $sections->mall()->paginate($this->limit);

        return $sections;
    }


    public function search($request)
    {
        return Section::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sections');
        }

        return Section::create($data);
    }


    public function update($request, $section)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sections', $section->image);
        }

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
