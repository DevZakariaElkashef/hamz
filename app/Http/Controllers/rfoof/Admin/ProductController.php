<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\FirebaseService;
use App\Models\Notification;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rfoof.products.index');
    }

    public function index($status)
    {
        $products = Product::rfoof();
        if ($status != 0 && $status != 'D') {
            $products = $products->Where('status', $status);
        }elseif ($status == 0) {
            $products = $products->where(function ($query) use ($status) {
                $query->where('status', $status)
                    ->orWhereNull('status');
            });
        }elseif ($status == 'D') {
            // show deleted products
            $products = $products->onlyTrashed();
        }
        $products = $products->latest()->paginate();
        return view('rfoof.products.index', compact('products', 'status'));
    }
    public function verify(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $product->verify = $product->verify == 1 ? 0 : 1 ;
        $product->save();

        session()->flash('message', ($product->verify == 1) ? 'تم اظهار الاعلان بنجاح' : 'تم اخفاء الاعلان بنجاح');
        return redirect()->back();
    }
    public function rejecet($id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'status' => 2,
        ]);
        $title = 'رفض الاعلان';
        $messageDataUser = 'نعتذر علي رفض الاعلان برجاء التواصل مع الاداره';

        Notification::create([
            'title_ar' => $title,
            'title_en' => $title,
            'message_ar' => $messageDataUser,
            'message_en' => $messageDataUser,
            'user_id' => $product->user_id,
            'product_id' => $product->id,
            'app' => 'rfoof'
        ]);
        $user = $product->user;
        if($user->device_token)
        {
            $firebase = new FirebaseService();
            $firebase->notify($title, $messageDataUser, $user->device_token);
        }
        // $this->to($product->user->device_token, $messageDataUser, $title);
        // $this->sendMail($product->user, $product, $messageDataUser, $title);
        return back()->with('message', 'تم رفض الاعلان بنجاح');
    }
    public function delete(Request $request){
        $product = Product::findOrFail($request->product_id);
        $product->delete();
        return back()->with('message', 'تم حذف المنتج بنجاح');
    }
    public function accepetAds($id)
    {
        $ads = Product::findOrFail($id);

        $ads->update([
            'status' => 1,
            'verify' => 1,
        ]);
        $title = 'موافقه علي الاعلان';
        $messageDataUser = 'تم الموافقه علي الاعلان بنجاح و ظهوره في التطبيق';

        Notification::create([
            'title_ar' => $title,
            'title_en' => $title,
            'message_ar' => $messageDataUser,
            'message_en' => $messageDataUser,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
            'app' => 'rfoof'
        ]);

        $user = $ads->user;
        if($user->device_token)
        {
            $firebase = new FirebaseService();
            $firebase->notify($title, $messageDataUser, $user->device_token);
        }
        // $this->to($ads->user->device_token, $messageDataUser, $title);
        // $this->sendMail($ads->user, $ads, $messageDataUser, $title);

        return back()->with('message', 'تم الموافقه علي الاعلان بنجاح');
    }
    public function discriminationAdsAction($id)
    {
        $ads = Product::findOrFail($id);

        $ads->update([
            'status' => 3,
            'verify' => 0,
        ]);
        $messageData = 'تم تمييز الاعلان الخاص بك بنجاح';
        $title = 'تمييز الاعلان';
        Notification::create([
            'subject' => $title,
            'message' => $messageData,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
            'app' => 'resale'
        ]);
        $this->to($ads->user->device_token, $messageData, $title);
        $this->sendMail($ads->user, $ads, $messageData, $title);

        return back()->with('message', 'تم تمييز الاعلان بنجاح');
    }
    public function blockAds($id)
    {
        $ads = Product::findOrFail($id);

        $ads->update([
            'status' => 4,
            'verify' => 0,
        ]);
        $messageData = 'تم حظر الاعلان الخاص بك برجاء التواصل مع الاداره ';
        $title = 'حظر الاعلان';
        Notification::create([
            'title_ar' => $title,
            'title_en' => $title,
            'message_ar' => $messageData,
            'message_en' => $messageData,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
            'app' => 'rfoof'
        ]);
        // $this->to($ads->user->device_token, $messageData, $title);
        // $this->sendMail($ads->user, $ads, $messageData, $title);
        $user = $ads->user;
        if($user->device_token)
        {
            $firebase = new FirebaseService();
            $firebase->notify($title, $messageData, $user->device_token);
        }
        return back()->with('message', 'تم حظر الاعلان بنجاح');
    }

    public function restore($id)
    {
        $ads = Product::where('id', $id)->withTrashed()->first();
        $ads->update([
            'status' => 1,
            'verify' => 1,
        ]);
        $ads->restore();
        $messageData = 'تم استرجاع الاعلان الخاص بك بنجاح ';
        $title = 'استرجاع الاعلان';
        Notification::create([
            'title_ar' => $title,
            'title_en' => $title,
            'message_ar' => $messageData,
            'message_en' => $messageData,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
            'app' => 'rfoof'
        ]);
        // $this->to($ads->user->device_token, $messageData, $title);
        // $this->sendMail($ads->user, $ads, $messageData, $title);

        return back()->with('message', 'تم استرجاع الاعلان بنجاح');
    }
    public static function sendMail($user, $ads, $messageData, $title)
    {
        Mail::send('Admin.emails.ads', compact('user', 'ads', 'messageData', 'title'), function ($message) use ($user, $ads, $messageData, $title) {
            $message->to($user->email);
            $message->subject($messageData);
        });
    }
    public function subCategories(Request $request)
    {
        $subCategories = SubCategory::rfoof()->where('category_id', $request->category_id)->get();
        return json_encode($subCategories);
    }

}
