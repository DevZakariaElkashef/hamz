<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ContactRepository;
use App\Http\Requests\Admin\ContactRequest;

class ContactUsController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->middleware('can:hamz.contacts.index')->only(['index']);
        $this->middleware('can:hamz.contacts.create')->only(['create', 'store']);
        $this->middleware('can:hamz.contacts.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.contacts.delete')->only(['destroy']);

        $this->contactRepository = $contactRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contacts = $this->contactRepository->index($request);
        return view('contacts.index', compact('contacts'));
    }

    public function search(Request $request)
    {
        $contacts = $this->contactRepository->search($request);
        return view('contacts.table', compact('contacts'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("contacts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $this->contactRepository->store($request); // store contact
        return to_route('contacts.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('contacts.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->contactRepository->update($request, $contact);
        return to_route('contacts.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Contact $contact)
    {
        $contact->update(['read_at' => $request->is_active ? now() : null]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->contactRepository->delete($contact);
        return to_route('contacts.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->contactRepository->deleteSelection($request);
        return to_route('contacts.index')->with('success', __("main.delete_successffully"));
    }
}
