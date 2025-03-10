<?php

namespace App\Repositories\Earn;

use App\Models\Video;
use App\Models\View;

class VideoRepository
{
    public function getVideos($request)
    {

        return Video::filterVideos($request)
        ->where('payment_status', 1)
        ->withCount('viewed') // Count the views
        ->whereHas('package', function ($query) {
            $query->whereRaw(
                '(SELECT COUNT(*) FROM views WHERE views.video_id = videos.id AND views.status = 1) < packages.limit'
            );
        })
        ->get();
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

        $alreadyWatched = View::where('video_id', $video->id)
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if ($alreadyWatched) {
            return 'already_watched';
        }

        $check = View::where('video_id', $video->id)
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->first();

        if (!$check) {
            return 'watch_first';
        }

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
