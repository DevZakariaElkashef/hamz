<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Models\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Earn\ViewRepository;
use App\Http\Requests\Earn\Web\ViewRequest;

class ViewController extends Controller
{
    protected $viewRepository;

    public function __construct(ViewRepository $viewRepository)
    {
        $this->viewRepository = $viewRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $views = $this->viewRepository->index($request);
        return view('earn.views.index', compact('views'));
    }

    public function search(Request $request)
    {
        $views = $this->viewRepository->search($request);
        return view('earn.views.table', compact('views'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("earn.views.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ViewRequest $request)
    {
        $this->viewRepository->store($request); // store view
        return to_route('earn.views.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.views.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(View $view)
    {
        return view('earn.views.edit', compact('view'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ViewRequest $request, View $view)
    {
        $this->viewRepository->update($request, $view);
        return to_route('earn.views.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, View $view)
    {
        $view->update(['status' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(View $view)
    {
        $this->viewRepository->delete($view);
        return to_route('earn.views.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->viewRepository->deleteSelection($request);
        return to_route('earn.views.index')->with('success', __("main.delete_successffully"));
    }
}
