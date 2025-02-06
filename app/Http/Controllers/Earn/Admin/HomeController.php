<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalVideos = Video::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('videos.user_id', auth()->user()->id);
        })->count();
        $totalViews = View::when(auth()->user()->role_id == 3, function ($query) {
            $query->join('videos', 'videos.id', '=', 'views.video_id')
                ->where('videos.user_id', auth()->user()->id);
        })->where('views.status', '1')
        ->count();

        $mostWatchedVideos = $this->getVideosWithViews('DESC');
        $mostUnWatchedVideos = $this->getVideosWithViews('ASC');

        return view("earn.index", compact('totalVideos', 'totalViews', 'mostWatchedVideos', 'mostUnWatchedVideos'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    private function getVideosWithViews($orderBy = 'desc', $limit = 5)
    {
        $local = app()->getLocale();
        $data = DB::table('videos')
            ->select("videos.title_" . $local  . ' AS title', 'videos.reword_amount', 'videos.path', DB::raw('SUM(CASE WHEN views.status = "1" THEN 1 ELSE 0 END) as views_count'))
            ->leftJoin('views', 'videos.id', '=', 'views.video_id')
            ->when(auth()->user()->role_id == 3, function ($query) {
                $query->where('videos.user_id', auth()->user()->id);
            })->groupBy('videos.id', "videos.title_" . $local, 'videos.reword_amount', 'videos.path')
            ->orderBy('views_count', $orderBy)
            ->limit($limit)
            ->get();

        return $data;
    }
}
