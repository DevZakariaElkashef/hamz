<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Models\View;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        // Count total videos and views in one query
        $totals = DB::selectOne('
            SELECT
                (SELECT COUNT(*) FROM videos) as total_videos,
                (SELECT COUNT(*) FROM views) as total_views
        ');

        // Retrieve the total values from the single query
        $totalVideos = $totals->total_videos;
        $totalViews = $totals->total_views;

        // Function to handle fetching watched and unwatched videos

        // Get most watched videos
        $mostWatchedVideos = $this->getVideosWithViews('desc');

        // Get least watched videos
        $mostUnWatchedVideos = $this->getVideosWithViews('asc');

        return view("earn.index", compact('totalVideos', 'totalViews', 'mostWatchedVideos', 'mostUnWatchedVideos'));
    }

    private function getVideosWithViews($orderBy = 'desc', $limit = 5)
    {
        $local = app()->getLocale();
        return DB::table('videos')
            ->select("videos.title_" .$local  . ' AS title', 'videos.reword_amount', 'videos.path', DB::raw('COUNT(views.id) as views_count'))
            ->leftJoin('views', 'videos.id', '=', 'views.video_id')
            ->groupBy('videos.id', "videos.title_" .$local, 'videos.reword_amount', 'videos.path')
            ->orderBy('views_count', $orderBy)
            ->limit($limit)
            ->get();
    }
}
