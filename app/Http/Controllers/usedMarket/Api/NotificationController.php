<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Traits\GeneralTrait;
use App\Http\Resources\Api\NotificationResource;
use App\Models\Notification;

class NotificationController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function getNotifications()
    {
        try{
            $notifications = NotificationResource::collection(Notification::where('user_id', request()->user()->id)->latest()->get());
            return $this->returnData("data", ["notifications" => $notifications], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function readAll()
    {
        try{
            $notifications = Notification::where('user_id', request()->user()->id)->latest()->get();
            foreach($notifications as $notification)
            {
                $notification->update(['status' => 1]);
            }
            return $this->returnSuccess(200, 'done');
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteNotifications(Request $request)
    {
        try{
            Notification::where('id', $request->notification_id)->delete();
            return $this->returnSuccess(200, __('api.deleteNotifications'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
