<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TermRepository;
use App\Http\Requests\Admin\TermRequest;

class TermController extends Controller
{
    protected $termRepository;

    public function __construct(TermRepository $termRepository)
    {
        $this->middleware('can:hamz.applications.index')->only(['index']);
        $this->termRepository = $termRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $terms = $this->termRepository->index($request);
        return view('settings.terms.index', compact('terms'));
    }

    public function search(Request $request)
    {
        $terms = $this->termRepository->search($request);
        return view('settings.terms.table', compact('terms'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("settings.terms.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermRequest $request)
    {
        $this->termRepository->store($request); // store term
        return to_route('terms.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('terms.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        return view('settings.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermRequest $request, Term $term)
    {
        $this->termRepository->update($request, $term);
        return to_route('terms.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Term $term)
    {
        $term->update(['read_at' => $request->is_active ? now() : null]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        $this->termRepository->delete($term);
        return to_route('terms.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->termRepository->deleteSelection($request);
        return to_route('terms.index')->with('success', __("main.delete_successffully"));
    }
}
