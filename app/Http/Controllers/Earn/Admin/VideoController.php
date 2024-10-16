<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Models\Category;
use App\Models\Video;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Earn\Web\VideoRequest;
use App\Repositories\Earn\WebVideoRepository;

class VideoController extends Controller
{
    protected $videoRepository;

    public function __construct(WebVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $videos = $this->videoRepository->index($request);
        return view('earn.videos.index', compact('videos'));
    }

    public function search(Request $request)
    {
        $videos = $this->videoRepository->search($request);
        return view('earn.videos.table', compact('videos'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = DB::select('SELECT * FROM categories WHERE `app` = "earn" AND `is_active` = 1');
        // $categories = Category::earn()->where('user_id', $request->user()->id)->active()->get();
        return view("earn.videos.create", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request)
    {
        $this->videoRepository->store($request); // store video
        return to_route('earn.videos.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.videos.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $categories = DB::select('SELECT * FROM categories WHERE `app` = "earn" AND `is_active` = 1');
        // $categories = Category::earn()->where('user_id', $request->user()->id)->active()->get();
        return view('earn.videos.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, Video $video)
    {
        $this->videoRepository->update($request, $video);
        return to_route('earn.videos.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Video $video)
    {
        $video->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->videoRepository->delete($video);
        return to_route('earn.videos.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->videoRepository->deleteSelection($request);
        return to_route('earn.videos.index')->with('success', __("main.delete_successffully"));
    }
}
