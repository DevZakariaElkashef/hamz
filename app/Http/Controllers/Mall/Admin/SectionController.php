<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\SectionRepository;
use App\Http\Requests\Mall\Web\SectionRequest;

class SectionController extends Controller
{
    use ImageUploadTrait;

        protected $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sections = $this->sectionRepository->index($request);
        return view('mall.sections.index', compact('sections'));
    }

    public function search(Request $request)
    {
        $sections = $this->sectionRepository->search($request);
        return view('mall.sections.table', compact('sections'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("mall.sections.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $this->sectionRepository->store($request); // store section
        return to_route('mall.sections.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.sections.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return view('mall.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section)
    {
        $this->sectionRepository->update($request, $section);
        return to_route('mall.sections.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $this->sectionRepository->delete($section);
        return to_route('mall.sections.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->sectionRepository->deleteSelection($request);
        return to_route('mall.sections.index')->with('success', __("mall.delete_successffully"));
    }
}
