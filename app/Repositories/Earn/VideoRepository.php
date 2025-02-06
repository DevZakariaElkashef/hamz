<?php

namespace App\Repositories\Earn;

use App\Models\Video;
use App\Models\View;

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

        // if (!$check) {
        //     return 'watch_first';
        // }

        $user->update([
            'watch_and_earn_wallet' => $user->watch_and_earn_wallet + $video->reword_amount,
        ]);

        $check->update(['status' => 1]);

        return $video->reword_amount;
    }

    public function startWatchingVideo($request, $video)
    {
        $view = View::where('user_id', $request->user()->id)
        ->where('video_id', $video->id)
        ->first();
        if ($view){
            if ($view->status == 1) {
                return false;
            }
            return true;
        }
        $view = new View();
        $view->user_id = $request->user()->id;
        $view->video_id = $video->id;
        $view->save();
        return true;
    }
}
