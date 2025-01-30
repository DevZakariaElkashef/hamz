<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Services\FirebaseService;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBasePushNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rfoof.notifications.index');
    }

    public function index()
    {
        $notifications = Notification::rfoof()->whereHas('user')->latest()->paginate();
        $users = User::where('role_id', 2)->get();
        return view('rfoof.notifications.index', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'message_ar' => 'required|string',
            'message_en' => 'required|string',
        ]);

        $notification = Notification::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'message_ar' => $request->message_ar,
            'message_en' => $request->message_en,
            'all' => ($request->choose) ? 1 : 0,
            'user_id' => (!$request->choose) ? $request->employee_id : null,
            'app' => 'rfoof'
        ]);
        if ($request->choose) {
            $users = User::where('role_id', 4)->get();
            foreach ($users as $user) {

                if ($request->phone_message) {
                    if($user->device_token)
                    {
                        $firebase = new FirebaseService();
                        $firebase->notify($request->title_ar, $request->message_ar, $user->device_token);
                    }
                }
                if ($request->sms_message) {
                    $this->_sendMessage($request->title_ar, $request->message_ar, $user->device);
                }
            }
        } else {
            $user = user::where('id', $request->employee_id)->first();
            if ($user) {

                if ($request->phone_message) {
                    if($user->device_token)
                    {
                        $firebase = new FirebaseService();
                        $firebase->notify($request->title_ar, $request->message_ar, $user->device_token);
                    }
                }
                if ($request->sms_message) {
                    $this->_sendMessage($request->title_ar, $request->message_ar, $user->device);
                }
            }
        }
        session()->flash('success', 'تم اضافة الاشعار بنجاح');
        return back();
    }

}
