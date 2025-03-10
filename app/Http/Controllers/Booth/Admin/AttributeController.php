<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Booth\AttributeExport;
use App\Imports\Booth\AttributeImport;
use App\Repositories\Booth\AttributeRepository;
use App\Http\Requests\Booth\Web\AttributeRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class AttributeController extends Controller
{
    protected $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;

        // autherization
        $this->middleware('can:booth.attributes.index')->only('index');
        $this->middleware('can:booth.attributes.create')->only(['create', 'store']);
        $this->middleware('can:booth.attributes.update')->only(['edit', 'update']);
        $this->middleware('can:booth.attributes.delete')->only('destroy');
        $this->middleware('can:booth.attributes.export')->only('export');
        $this->middleware('can:booth.attributes.import')->only('import');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepository->index($request);
        return view('booth.attributes.index', compact('attributes'));
    }

    public function search(Request $request)
    {
        $attributes = $this->attributeRepository->search($request);
        return view('booth.attributes.table', compact('attributes'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new AttributeExport($request), 'attributes.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new AttributeImport, $request->file('file'));

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
        return view("booth.attributes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request)
    {
        $this->attributeRepository->store($request); // store attribute
        return to_route('booth.attributes.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('booth.attributes.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('booth.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $this->attributeRepository->update($request, $attribute);
        return to_route('booth.attributes.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Attribute $attribute)
    {
        $attribute->update(['is_active' => $request->is_active]);

        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $this->attributeRepository->delete($attribute);
        return to_route('booth.attributes.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->attributeRepository->deleteSelection($request);
        return to_route('booth.attributes.index')->with('success', __("main.delete_successffully"));
    }
}
