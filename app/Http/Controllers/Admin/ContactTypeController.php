<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ContactTypeRepository;
use App\Http\Requests\Admin\ContactTypeRequest;

class ContactTypeController extends Controller
{
    protected $contacttypeRepository;

    public function __construct(ContactTypeRepository $contacttypeRepository)
    {
        $this->contacttypeRepository = $contacttypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contactTypes = $this->contacttypeRepository->index($request);
        return view('contacttypes.index', compact('contactTypes'));
    }

    public function search(Request $request)
    {
        $contactTypes = $this->contacttypeRepository->search($request);
        return view('contacttypes.table', compact('contactTypes'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("contacttypes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactTypeRequest $request)
    {
        $this->contacttypeRepository->store($request); // store contacttype
        return to_route('contactTypes.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('contactTypes.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactType $contactType)
    {
        return view('contacttypes.edit', compact('contactType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactTypeRequest $request, ContactType $contactType)
    {
        $this->contacttypeRepository->update($request, $contactType);
        return to_route('contactTypes.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, ContactType $contactType)
    {
        $contactType->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactType $contactType)
    {
        $this->contacttypeRepository->delete($contactType);
        return to_route('contactTypes.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->contacttypeRepository->deleteSelection($request);
        return to_route('contactTypes.index')->with('success', __("main.delete_successffully"));
    }
}
