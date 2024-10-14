<?php

namespace App\Repositories\Earn;

use App\Models\Video;
use App\Traits\ImageUploadTrait;

class WebVideoRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $videos = Video::filter($request)->earn()->paginate($request->per_page ?? $this->limit);

        return $videos;
    }


    public function search($request)
    {
        return Video::earn()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'videos');
        }
        return Video::create($data);
    }


    public function update($request, $video)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'videos', $video->image);
        }
        $video->update($data);
        return $video;
    }


    public function delete($video)
    {
        $video->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Video::whereIn('id', $ids)->delete();
        return true;
    }
}
