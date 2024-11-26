<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Exports\Booth\SectionExport;
use App\Imports\Booth\SectionImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Booth\SectionRepository;
use App\Http\Requests\Booth\Web\SectionRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class SectionController extends Controller
{

    protected $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;

        // autherization
        $this->middleware('can:booth.sections.index')->only('index');
        $this->middleware('can:booth.sections.create')->only(['create', 'store']);
        $this->middleware('can:booth.sections.update')->only(['edit', 'update']);
        $this->middleware('can:booth.sections.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sections = $this->sectionRepository->index($request);
        return view('booth.sections.index', compact('sections'));
    }

    public function search(Request $request)
    {
        $sections = $this->sectionRepository->search($request);
        return view('booth.sections.table', compact('sections'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new SectionExport($request), 'sections.xlsx');
    }


    public function import(Request $request)
    {
        try {
            Excel::import(new SectionImport, $request->file('file'));

            return back()->with('success', __("main.created_successfully"));
        } catch (ValidationException $e) {
            // Get the first failure from the exception
            $failure = $e->failures()[0];

            // Format the error message for the first failed row
            $errorMessage = "Row {$failure->row()}: " . implode(', ', $failure->errors());

            // Flash the error message to the session
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Handle any other exceptions that might occur
            return back()->with('error', __("An unexpected error occurred: " . $e->getMessage()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("booth.sections.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $this->sectionRepository->store($request); // store section
        return to_route('booth.sections.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('booth.sections.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return view('booth.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section)
    {
        $this->sectionRepository->update($request, $section);
        return to_route('booth.sections.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Section $section)
    {
        $section->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $this->sectionRepository->delete($section);
        return to_route('booth.sections.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->sectionRepository->deleteSelection($request);
        return to_route('booth.sections.index')->with('success', __("main.delete_successffully"));
    }
}
