<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // get the user view 
        $notifications = Notification::earn()
        ->where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')->get();
        return view('earn.notification.index', compact('notifications'));
    }
}
