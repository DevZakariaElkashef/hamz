<?php

namespace App\Repositories;

use App\Models\Term;
use App\Traits\ImageUploadTrait;

class TermRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $terms = Term::filter($request)->paginate($request->per_page ?? $this->limit);

        return $terms;
    }


    public function search($request)
    {
        return Term::paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('icon');
        if ($request->hasFile('icon')) {
            $data['icon'] =  $this->uploadImage($request->file('icon'), 'terms');
        }
        unset($data['_token']);
        return Term::create($data);
    }


    public function update($request, $term)
    {
        $data = $request->except('icon');
        if ($request->hasFile('icon')) {
            $data['icon'] =  $this->uploadImage($request->file('icon'), 'terms', $term->icon);
        }
        unset($data['_token'], $data['_method']);
        $term->update($data);
        return $term;
    }


    public function delete($term)
    {
        $term->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Term::whereIn('id', $ids)->delete();
        return true;
    }
}
