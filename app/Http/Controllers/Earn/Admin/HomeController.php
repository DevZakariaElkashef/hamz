<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\View;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $videos_condition = '';
        $views_condition = '';
        $store_id = null;

        if ($user->role->name == 'seller') {
            $store_id = $user->store->id ?? 'non';
            $videos_condition = "where store_id = $store_id";
            $video_ids = Video::where('store_id', $store_id)->pluck('id')->toArray();
            if (count($video_ids) < 1) {
                $video_ids = [0];
            }
            $video_ids = implode(',', $video_ids);
            $views_condition = "where video_id in ($video_ids)";
        }

        // Count total videos and views in one query
        $totals = DB::selectOne("
            SELECT
                (SELECT COUNT(*) FROM videos $videos_condition) as total_videos,
                (SELECT COUNT(*) FROM views $views_condition) as total_views
        ");

        // Retrieve the total values from the single query
        $totalVideos = $totals->total_videos;
        $totalViews = $totals->total_views;

        // Function to handle fetching watched and unwatched videos

        // Get most watched videos
        $mostWatchedVideos = $this->getVideosWithViews('desc', $store_id);

        // Get least watched videos
        $mostUnWatchedVideos = $this->getVideosWithViews('asc', $store_id);

        return view("earn.index", compact('totalVideos', 'totalViews', 'mostWatchedVideos', 'mostUnWatchedVideos'));
    }

    private function getVideosWithViews($orderBy = 'desc', $store_id = null, $limit = 5)
    {
        $local = app()->getLocale();
        $data = DB::table('videos')
            ->select("videos.title_" .$local  . ' AS title', 'videos.reword_amount', 'videos.path', DB::raw('COUNT(views.id) as views_count'))
            ->leftJoin('views', 'videos.id', '=', 'views.video_id');
        if($store_id){
            $data = $data->where('videos.store_id', operator: $store_id);
        }
        $data = $data->groupBy('videos.id', "videos.title_" .$local, 'videos.reword_amount', 'videos.path')
            ->orderBy('views_count', $orderBy)
            ->limit($limit)
            ->get();
        return $data;
    }
}
