<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Traits\GeneralTrait;
use App\Traits\ImageUploadTrait;
use App\Models\Chat;
use App\Http\Resources\Api\ChatResource;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class ChatController extends Controller
{
    use GeneralTrait, ImageUploadTrait;
    private $url = 'https://fcm.googleapis.com/v1/projects/yourmarket-34468/messages:send';
    private $scope = "https://www.googleapis.com/auth/firebase.messaging";
    private $token;

    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
        $jsonPath = storage_path('app/firebase-service-account.json');

    // Provide the path where you stored the json token, in my case, I stored it in database
        $creadentials = new ServiceAccountCredentials($this->scope, $jsonPath);
        $this->token = $creadentials->fetchAuthToken(HttpHandlerFactory::build());
    }
    public function getMessages(Request $request)
    {
        try{
            $messages = ChatResource::collection(Chat::where(['user_id' => $request->user_id, 'product_id' => $request->product_id])->get());
            return $this->returnData("data", ['messages' => $messages], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function sendMessage(Request $request)
    {
        try{
            $product = Products::find($request->product_id);
            if($product->user_id == $request->user()->id)
            {
                $message = Chat::find($request->chat_id);
                Chat::create([
                    'message' => $request->message,
                    'user_id' => $message->user_id,
                    'seller_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'type' => 'reply'
                ]);
                $firebase = new \App\Http\Controllers\Web\FireBasePushNotification();
                $this->to($message->user->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
            }
            else
            {
                $message = Chat::create([
                    'message' => $request->message,
                    'user_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'seller_id' => $product->user_id,
                    'type' => 'sending'
                ]);
                $firebase = new \App\Http\Controllers\Web\FireBasePushNotification();
                $this->to($message->seller->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
            }
            return $this->returnSuccess(200, __('api.sendMessage'));
            $messages = ChatResource::collection(Chat::where(['user_id' => $request->user_id, 'product_id' => $request->product_id])->get());
            return $this->returnData("data", ['messages' => $messages], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function getChats(Request $request)
    {
        try{
            $lastMessagesUsers = Chat::select('chats.*')->where('user_id', $request->user()->id)
                ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
                                 FROM chats
                                 GROUP BY product_id) as latest_chats'), function ($join) {
                    $join->on('chats.product_id', '=', 'latest_chats.product_id')
                         ->on('chats.created_at', '=', 'latest_chats.last_message_time');
                })
                ->get();

            $lastMessagesChats = Chat::select('chats.*')->where('seller_id', $request->user()->id)
                ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
                                 FROM chats
                                 GROUP BY product_id) as latest_chats'), function ($join) {
                    $join->on('chats.product_id', '=', 'latest_chats.product_id')
                         ->on('chats.created_at', '=', 'latest_chats.last_message_time');
                })
                ->get();
            // Combine both message sets
            $messages = $lastMessagesUsers->merge($lastMessagesChats);

            // Sort messages by last_message_time in descending order
            $messages = $messages->sortByDesc('last_message_time')->values()->all();
                 $messages = ChatResource::collection($messages);
            return $this->returnData("data", ["cahts" => $messages], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function to($device, $body, $title = "My favorite App")
    {
        $data = [
            'token' => $device,
            'title' => $title,
            'body' => $body
        ];

        return $this->send($data);
    }

    public function send($data)
    {
        $headers = [
            'Authorization: Bearer ' . $this->token['access_token'],
            'Content-Type: application/json'
        ];

        $fields = [
            'message' => [
                'token' => $data['token'],
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['body']
                ]
            ]
        ];

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);
        INFO($result);
        return $result;
    }
}
