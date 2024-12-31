<?php

namespace App\Http\Controllers\rfoof\Api;

use App\Models\Chat;
use App\Models\Product;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\rfoof\ChatResource;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use App\Http\Controllers\FireBasePushNotification;
use Google\Auth\Credentials\ServiceAccountCredentials;

class ChatController extends Controller
{
    use GeneralTrait, ImageUploadTrait;
    private $url = 'https://fcm.googleapis.com/v1/projects/hamz-52a65/messages:send';
    private $scope = "https://www.googleapis.com/auth/firebase.messaging";
    private $token;

    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
        $jsonPath = storage_path('app/hamz-firebase.json');

        // Provide the path where you stored the json token, in my case, I stored it in database
        $creadentials = new ServiceAccountCredentials($this->scope, $jsonPath);
        $this->token = $creadentials->fetchAuthToken(HttpHandlerFactory::build());
    }


    public function getMessages(Request $request)
    {
        try {
            $messages = ChatResource::collection(Chat::rfoof()->where(['user_id' => $request->user_id, 'product_id' => $request->product_id])->get());
            return $this->returnData("data", ['messages' => $messages], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function sendMessage(Request $request)
    {
        try {
            $product = Product::find($request->product_id);
            if ($product->user_id == $request->user()->id) {
                $message = Chat::find($request->chat_id);
                Chat::create([
                    'message' => $request->message,
                    'user_id' => $message->user_id,
                    'seller_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'type' => 'reply',
                    'app' => 'rfoof'
                ]);
                $firebase = new FireBasePushNotification();
                $this->to($message->user->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
            } else {
                $message = Chat::create([
                    'message' => $request->message,
                    'user_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'seller_id' => $product->user_id,
                    'type' => 'sending',
                    'app' => 'rfoof'
                ]);
                $firebase = new FireBasePushNotification();
                $this->to($message->seller->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
            }
            return $this->returnSuccess(200, __('main.sendMessage'));

            $messages = ChatResource::collection(Chat::rfoof()->where(['user_id' => $request->user_id, 'product_id' => $request->product_id])->get());

            return $this->returnData("data", ['messages' => $messages], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function getChats(Request $request)
    {
        try {
            $lastMessagesUsers = Chat::select('chats.*')->rfoof()->where('user_id', $request->user()->id)
                ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
                                FROM chats
                                GROUP BY product_id) as latest_chats'), function ($join) {
                    $join->on('chats.product_id', '=', 'latest_chats.product_id')
                        ->on('chats.created_at', '=', 'latest_chats.last_message_time');
                })
                ->get();

            $lastMessagesChats = Chat::select('chats.*')->rfoof()->where('seller_id', $request->user()->id)
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
            return $this->returnData("data", ["cahts" => $messages], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function to($device, $body, $title = "My favorite App")
    {
        $data = [
            'token' => $device,
            'title' => $title,
            'body' => $body,
        ];

        return $this->send($data);
    }

    public function send($data)
    {
        $headers = [
            'Authorization: Bearer ' . $this->token['access_token'],
            'Content-Type: application/json',
        ];

        $fields = [
            'message' => [
                'token' => $data['token'],
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['body'],
                ],
            ],
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
