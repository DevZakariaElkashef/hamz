<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Exports\Mall\OptionExport;
use App\Models\Option;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\OptionRepository;
use App\Http\Requests\Mall\Web\OptionRequest;

class OptionController extends Controller
{
    protected $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $options = $this->optionRepository->index($request);
        $attributes = Attribute::mall()->active()->get();
        return view('mall.options.index', compact('options', 'attributes'));
    }

    public function search(Request $request)
    {
        $options = $this->optionRepository->search($request);
        return view('mall.options.table', compact('options'))->render();
    }

    public function getOptionsByAttribute(Request $request)
    {
        $items = Option::where('attribute_id', $request->attributeId)->get();
        return view('mall.layouts._options', compact('items'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new OptionExport($request), 'options.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::mall()->active()->get();
        return view("mall.options.create", compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionRequest $request)
    {
        $this->optionRepository->store($request); // store option
        return to_route('mall.options.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.options.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        $attributes = Attribute::mall()->active()->get();
        return view('mall.options.edit', compact('option', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionRequest $request, Option $option)
    {
        $this->optionRepository->update($request, $option);
        return to_route('mall.options.index')->with('success', __("mall.updated_successffully"));
    }

    public function toggleStatus(Request $request, Option $option)
    {
        $option->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("mall.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        $this->optionRepository->delete($option);
        return to_route('mall.options.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->optionRepository->deleteSelection($request);
        return to_route('mall.options.index')->with('success', __("mall.delete_successffully"));
    }
}
