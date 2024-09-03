<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\AttributeRepository;
use App\Http\Requests\Mall\Web\AttributeRequest;

class AttributeController extends Controller
{
    protected $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepository->index($request);
        return view('mall.attributes.index', compact('attributes'));
    }

    public function search(Request $request)
    {
        $attributes = $this->attributeRepository->search($request);
        return view('mall.attributes.table', compact('attributes'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("mall.attributes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request)
    {
        $this->attributeRepository->store($request); // store attribute
        return to_route('mall.attributes.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.attributes.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('mall.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $this->attributeRepository->update($request, $attribute);
        return to_route('mall.attributes.index')->with('success', __("mall.updated_successffully"));
    }

    public function toggleStatus(Request $request, Attribute $attribute)
    {
        $attribute->update(['is_active' => $request->is_active]);
        
        return response()->json([
            'success' => true,
            'message' => __("mall.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $this->attributeRepository->delete($attribute);
        return to_route('mall.attributes.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->attributeRepository->deleteSelection($request);
        return to_route('mall.attributes.index')->with('success', __("mall.delete_successffully"));
    }
}
