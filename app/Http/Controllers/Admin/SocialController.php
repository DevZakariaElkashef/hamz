<?php

namespace App\Http\Controllers\Admin;

use App\Models\Social;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SocialRepository;
use App\Http\Requests\Admin\SocialRequest;

class SocialController extends Controller
{
    protected $socialRepository;

    public function __construct(SocialRepository $socialRepository)
    {
        $this->middleware('can:hamz.socials.index')->only(['index']);
        $this->middleware('can:hamz.socials.create')->only(['create', 'store']);
        $this->middleware('can:hamz.socials.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.socials.delete')->only(['destroy']);

        $this->socialRepository = $socialRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $socials = $this->socialRepository->index($request);
        return view('socials.index', compact('socials'));
    }

    public function search(Request $request)
    {
        $socials = $this->socialRepository->search($request);
        return view('socials.table', compact('socials'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("socials.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialRequest $request)
    {
        $this->socialRepository->store($request); // store social
        return to_route('socials.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('socials.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Social $social)
    {
        return view('socials.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialRequest $request, Social $social)
    {
        $this->socialRepository->update($request, $social);
        return to_route('socials.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Social $social)
    {
        $social->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Social $social)
    {
        $this->socialRepository->delete($social);
        return to_route('socials.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->socialRepository->deleteSelection($request);
        return to_route('socials.index')->with('success', __("main.delete_successffully"));
    }
}
