<?php

namespace App\Http\Controllers\rfoof\Api;

use App\Models\Chat;
use App\Models\Product;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\rfoof\ChatResource;
use App\Http\Resources\rfoof\MassageResource;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class ChatController extends Controller
{
    use GeneralTrait, ImageUploadTrait;
    private $url = 'https://fcm.googleapis.com/v1/projects/hamz-52a65/messages:send';
    private $scope = "https://www.googleapis.com/auth/firebase.messaging";
    private $token;

    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
        // $jsonPath = storage_path('app/hamz-firebase.json');

        // // Provide the path where you stored the json token, in my case, I stored it in database
        // $creadentials = new ServiceAccountCredentials($this->scope, $jsonPath);
        // $this->token = $creadentials->fetchAuthToken(HttpHandlerFactory::build());
    }


    public function getMessages(Request $request)
    {
        try {
            $validated = $request->validate([
                'other_id' => [
                    'required',
                    'integer',
                    'exists:users,id', // Ensure receiver_id exists in the users table
                ],
                'product_id' => [
                    'required',
                    'integer',
                    'exists:products,id', // Ensure product_id exists in the products table
                ],
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
                'data' => ''
            ], 400);
        }
        try {
            $auth = $request->user();
            $auth_id = $auth->id;
            $other_id = $request->other_id;

            $messages = Chat::where('product_id', $request->product_id)
            ->where(function ($query) use ($auth_id, $other_id) {
                $query->where(function ($q) use ($auth_id, $other_id) {
                    $q->where('user_id', $other_id)
                    ->where('seller_id', $auth_id);
                })->orWhere(function ($q) use ($auth_id, $other_id) {
                    $q->where('user_id', $auth_id)
                    ->where('seller_id', $other_id);
                });
            })->whereHas('product', function ($query) {
                $query->where('app', 'rfoof');
            })
            ->orderBy('created_at', 'DESC') // Order messages chronologically
            ->get();
            $messages = MassageResource::collection($messages);
            $other = User::find($other_id);
            $product = User::find($request->product_id);
            $chatData = [
                'other_id' => $other->id,
                'other_name' => $other->name,
                'other_image' => asset($other->image)?? '',
                'product_id' => $product->id,
                'product_name' => $product->name,
                'messages' => $messages
            ];
            return $this->returnData("data", ['chatData' => $chatData], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
        /*
                        // If no messages are found, return a 404 response
            // if ($messages->isEmpty()) {
            //     return response()->json(['message' => 'No messages found in this chat'], 404);
            // }
            // $message_ids = Chat::select('id')
            // ->where(function ($query) use ($auth_id) {
            //     $query->where('user_id', $auth_id)
            //         ->orWhere('seller_id', $auth_id);
            // })
            // ->groupByRaw('LEAST(user_id, seller_id), GREATEST(user_id, seller_id), product_id')
            // ->get()->pluck('id');
            // $messages = Chat::where('product_id', $request->product_id)
            // ->where(function ($query) use ($auth_id) {
            //     $query->where('user_id', $auth_id)
            //         ->orWhere('seller_id', $auth_id);
            // })->orderBy('created_at', 'DESC')->get();
            // $messages = MassageResource::collection($messages);
            // return $this->returnData("data", ['messages' => $messages], __('main.returnData'));
        */
    }
    public function sendMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'receiver_id' => [
                    'required', 'integer',
                    'exists:users,id', // Ensure receiver_id exists in the users table
                ],
                'product_id' => [
                    'required', 'integer',
                    'exists:products,id', // Ensure product_id exists in the products table
                ],
                'message' => ['required', 'string',],
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
                'data' => ''
            ], 400);
        }
        try {
            $product = Product::find($request->product_id);
            if($product){
                Chat::create([
                    'message' => $request->message,
                    'user_id' => $request->user()->id,
                    'seller_id' => $request->receiver_id,
                    'product_id' => $request->product_id,
                    'type' => 'reply',
                    'app' => 'rfoof'
                ]);
            }
            return $this->returnSuccess(200, __('main.sendMessage'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
        /*
                // if ($product->user_id == $request->user()->id) {
                //     $message = Chat::find($request->chat_id);
                //     // $firebase = new FireBasePushNotification();
                //     // $this->to($message->user->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
                // } else {
                //     $message = Chat::create([
                //         'message' => $request->message,
                //         'user_id' => $request->user()->id,
                //         'product_id' => $request->product_id,
                //         'seller_id' => $product->user_id,
                //         'type' => 'sending',
                //         'app' => 'resale'
                //     ]);
                //     // $firebase = new FireBasePushNotification();
                //     // $this->to($message->seller->device_token, $request->message, 'رساله جديده من اعلان:' . $message->product->name());
                // }

                // $messages = ChatResource::collection(Chat::usedMarket()
                // ->where(['user_id' => $request->user_id, 'product_id' => $request->product_id])
                // ->get());

                // return $this->returnData("data", ['messages' => $messages], __('main.returnData'));
            */
    }

    public function getChats(Request $request)
    {
        try {
            $auth = $request->user();
            $auth_id = $auth->id;
            $last_message_id = Chat::selectRaw('MAX(id) as last_message_id')
            ->where(function ($query) use ($auth_id) {
                $query->where('user_id', $auth_id)
                    ->orWhere('seller_id', $auth_id);
            })->whereHas('product', function ($query) {
                $query->where('app', 'rfoof');
            })
            ->groupByRaw('LEAST(user_id, seller_id), GREATEST(user_id, seller_id), product_id')
            ->get()->pluck('last_message_id');
            $chats = Chat::whereIn('id',$last_message_id)->orderBy('created_at', 'DESC')
            ->get();
            $chats = ChatResource::collection($chats);
            return $this->returnData("data", ["cahts" => $chats], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
        /*
            // if($request->user()->role->name == 'seller'){
            //     $subQuery = Chat::selectRaw('MAX(id) as last_message_id')
            //     ->where(function ($query) use ($authId) {
            //         $query->where('user_id', $authId)
            //             ->orWhere('seller_id', $authId);
            //     })
            //     ->groupByRaw('LEAST(user_id, seller_id), GREATEST(user_id, seller_id), product_id');
            // }elseif($request->user()->role->name == 'client'){
            //     $cahts = Chat::select('chats.*')->where('user_id', $request->user()->id)
            //     ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
            //                     FROM chats
            //                     GROUP BY product_id) as latest_chats'), function ($join) {
            //         $join->on('chats.product_id', '=', 'latest_chats.product_id')
            //             ->on('chats.created_at', '=', 'latest_chats.last_message_time');
            //     })
            //     ->get();
            //     return $cahts;
            // }
            // $lastMessagesUsers = Chat::select('chats.*')->where('user_id', $request->user()->id)
            // ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
            //                 FROM chats
            //                 GROUP BY product_id) as latest_chats'), function ($join) {
            //     $join->on('chats.product_id', '=', 'latest_chats.product_id')
            //         ->on('chats.created_at', '=', 'latest_chats.last_message_time');
            // })
            // ->get();
            // $lastMessagesChats = Chat::select('chats.*')->where('seller_id', $request->user()->id)
            // ->join(DB::raw('(SELECT product_id, MAX(created_at) as last_message_time
            //                 FROM chats
            //                 GROUP BY product_id) as latest_chats'), function ($join) {
            //     $join->on('chats.product_id', '=', 'latest_chats.product_id')
            //         ->on('chats.created_at', '=', 'latest_chats.last_message_time');
            // })
            // ->get();
            // Combine both message sets
            // $messages = $lastMessagesUsers->merge($lastMessagesChats);
            // Sort messages by last_message_time in descending order
            // $messages = $messages->sortByDesc('last_message_time')->values()->all();
            // $messages = ChatResource::collection($messages);
            // return $this->returnData("data", ["cahts" => $messages], __('main.returnData'));
        */
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
