<?php

namespace App\Http\Controllers\Earn\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Earn\VideoResource;
use App\Repositories\Earn\VideoRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ApiResponse;

    protected $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function index(Request $request)
    {
        $videos = $this->videoRepository->getVideos($request);
        $data = VideoResource::collection($videos);
        return $this->sendResponse(200, $data);
    }

    public function show(Request $request, $id)
    {
        $video = $this->videoRepository->getVideoById($id);
        if (!$video) {
            return $this->sendResponse(404, '', __("Not Found"));
        }

        $check = $video->viewed()->where('user_id', $request->user()->id)->where('status', 1)->first();

        if ($check) {
            return $this->sendResponse(400, '', __("main.already_watched"));
        }

        $this->videoRepository->startWatchingVideo($request, $video);
        $data = new VideoResource($video);

        return $this->sendResponse(200, $data);
    }

    public function next(Request $request)
    {
        $video = $request->user()->getUnwatchedVideos()
        ->first();
        if (!$video) {
            return $this->sendResponse(404, '', __("main.there_is_not_videos_at_the_moment"));
        }

        $this->videoRepository->startWatchingVideo($request, $video);
        $data = new VideoResource($video);

        return $this->sendResponse(200, $data);
    }

    public function finish(Request $request, $id)
    {
        $result = $this->videoRepository->finishVideo($request, $id);

        if ($result === null) {
            return $this->sendResponse(404, '', __("Not Found"));
        } elseif ($result === 'already_watched') {
            return $this->sendResponse(400, '', __("main.already_watched"));
        } elseif ($result === 'watch_first') {
            return $this->sendResponse(400, '', __("main.watch_video_first"));
        }

        return $this->sendResponse(200, '', __('main.you_won', ['x' => $result]));
    }
}
