<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
use App\Http\Resources\Earn\VideoResource;
use App\Models\Video;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $videos = Video::query()
            ->earn()
            ->active()
            ->whereDoesntHave('viewed', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id); // Assuming the user is authenticated
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->get();

        $data = VideoResource::collection($videos);
        return $this->sendResponse(200, $videos);
    }

    public function show(Request $request, $id)
    {
        $video = Video::find($id);
        if (!$video) {
            return $this->sendResponse(404, '', __("Not Found"));
        }

        $check = $video->viewed->where('user_id', $request->user()->id)->first();
        if ($check) {
            return $this->sendResponse(403, '', __("Already Seen!"));
        }

        $video->viewed()->create(['user_id' => $request->user()->id]);
        $data = new VideoResource($video);

        return $this->sendResponse(200, $data);
    }

    public function next(Request $request)
    {
        $video = Video::query()
            ->earn()
            ->active()
            ->whereDoesntHave('viewed', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->first();

        if ($video) {

            $check = $video->viewed->where('user_id', $request->user()->id)->first();
            if ($check) {
                return $this->sendResponse(403, '', __("Already Seen!"));
            }

            $video->viewed()->create(['user_id' => $request->user()->id]);
        }

        $data = new VideoResource($video);
        $message = $video ? '' : __("earn.there_is_not_videos_at_the_moment");
        return $this->sendResponse(200, $data, $message);
    }
}
