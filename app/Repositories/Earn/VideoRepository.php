<?php

namespace App\Repositories\Earn;

use App\Models\Video;
use App\Traits\ApiResponse;

class VideoRepository
{
    public function getVideos($request)
    {
        return Video::filterVideos($request)->get();
    }

    public function getVideoById($id)
    {
        return Video::find($id);
    }

    public function getNextVideo($request)
    {
        return Video::nextVideo($request);
    }

    public function finishVideo($request, $id)
    {
        $user = $request->user();
        $video = Video::find($id);

        if (!$video) {
            return null;
        }

        $alreadyWatched = $video->viewed()
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if ($alreadyWatched) {
            return 'already_watched';
        }

        $check = $video->viewed()
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->first();

        if (!$check) {
            return 'watch_first';
        }

        $user->update([
            'wallet' => $user->wallet + $video->reward_amount,
        ]);

        $check->update(['status' => 1]);

        return $video->reward_amount;
    }

    public function startWatchingVideo($request, $video)
    {
        $check = $video->viewed()
            ->where('user_id', $request->user()->id)
            ->where('status', 1)
            ->first();

        if ($check) {
            return false;
        }

        $video->viewed()->create(['user_id' => $request->user()->id]);

        return true;
    }
}
