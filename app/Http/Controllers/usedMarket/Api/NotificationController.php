<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Models\Notification;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\Usedmarket\NotificationResource;

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
            $notifications = NotificationResource::collection(Notification::usedMarket()->where('user_id', request()->user()->id)->latest()->get());
            return $this->returnData("data", ["notifications" => $notifications], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function readAll()
    {
        try{
            $notifications = Notification::usedMarket()->where('user_id', request()->user()->id)->latest()->get();
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
            Notification::usedMarket()->where('id', $request->notification_id)->delete();
            return $this->returnSuccess(200, __('main.deleteNotifications'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
