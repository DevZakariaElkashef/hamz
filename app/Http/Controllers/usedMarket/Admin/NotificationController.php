<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::resale()->whereHas('user')->latest()->paginate();
        $users = User::where('role_id', 2)->get();
        return view('usedMarket.notifications.index', compact('notifications', 'users'));
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
            'user_id' => (!$request->choose) ? $request->employee_id : null
        ]);
        if ($request->choose) {
            $users = User::where('role_id', 4)->get();
            foreach ($users as $user) {

                if ($request->phone_message) {
                    if($user->device_token)
                    {
                        $firebase = new FireBasePushNotification();
                        $firebase->to($user->device_token, $request->message_ar, $request->title_ar);
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
                        $firebase = new FireBasePushNotification();
                        $firebase->to($user->device_token, $request->message_ar, $request->title_ar);
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
