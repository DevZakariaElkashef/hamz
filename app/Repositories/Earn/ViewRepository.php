<?php

namespace App\Repositories\Earn;

use App\Models\View;
use App\Traits\ImageUploadTrait;

class ViewRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $views = View::filter($request)->paginate($request->per_page ?? $this->limit);

        return $views;
    }


    public function search($request)
    {
        return View::search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'views');
        }
        unset($data['_token']);
        return View::create($data);
    }


    public function update($request, $view)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'views', $view->image);
        }
        unset($data['_token'], $data['_method']);
        $view->update($data);
        return $view;
    }


    public function delete($view)
    {
        $view->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        View::whereIn('id', $ids)->delete();
        return true;
    }
}
