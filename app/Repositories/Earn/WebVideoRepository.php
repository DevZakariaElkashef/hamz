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
        $videos = Video::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->filter($request)->earn()->withCount('viewed')->paginate($request->per_page ?? $this->limit);

        return $videos;
    }


    public function search($request)
    {
        return Video::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->earn()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('thumbnail');
        $data['app'] = 'earn';
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] =  $this->uploadImage($request->file('thumbnail'), 'videos');
        }
        $data['app'] = 'earn';
        unset($data['_token']);
        return Video::create($data);
    }


    public function update($request, $video)
    {
        $data = $request->except(['thumbnail']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] =  $this->uploadImage($request->file('thumbnail'), 'videos', $video->thumbnail);
        }

        unset($data['_token'], $data['_method']);
        $video->update($data);

        return $video;
    }


    public function delete($video)
    {
        if ($video->thumbnail) {
            $this->deleteImage($video->thumbnail);
        }

        if ($video->path) {
            $this->deleteImage($video->path);
        }

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
