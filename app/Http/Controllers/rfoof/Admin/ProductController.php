<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index($status)
    {
        $products = Product::rfoof()->whereHas('images')->where('status', $status)->latest()->paginate();
        return view('rfoof.products.index', compact('products', 'status'));
    }
    public function verify(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $product->update([
            'verify' => ($product->is_active == 1) ? 0 : 1,
        ]);

        session()->flash('message', ($product->is_active == 1) ? 'تم اظهار الاعلان بنجاح' : 'تم اخفاء الاعلان بنجاح');
        return redirect()->back();
    }
    public function rejecet($id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'status' => 2
        ]);
        $title = 'رفض الاعلان';
        $messageDataUser = 'نعتذر علي رفض الاعلان برجاء التواصل مع الاداره';

        Notification::create([
            'subject' => $title,
            'message' => $messageDataUser,
            'user_id' => $product->user_id,
            'product_id' => $product->id,
        ]);

        $this->to($product->user->device_token, $messageDataUser, $title);
        $this->sendMail($product->user, $product, $messageDataUser, $title);
        return back()->with('message', 'تم رفض الاعلان بنجاح');
    }
    public function accepetAds($id)
    {
        $ads = Product::findOrFail($id);

        $ads->update([
            'status' => 1,
            'verify' => 1
        ]);
        $title = 'موافقه علي الاعلان';
        $messageDataUser = 'تم الموافقه علي الاعلان بنجاح و ظهوره في التطبيق';

        Notification::create([
            'subject' => $title,
            'message' => $messageDataUser,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
        ]);

        $this->to($ads->user->device_token, $messageDataUser, $title);
        $this->sendMail($ads->user, $ads, $messageDataUser, $title);

        return back()->with('message', 'تم الموافقه علي الاعلان بنجاح');
    }
    public function discriminationAdsAction($id)
    {
        $ads = Product::findOrFail($id);

        $ads->update([
            'status' => 3,
            'verify' => 0
        ]);
        $messageData = 'تم تمييز الاعلان الخاص بك بنجاح';
        $title = 'تمييز الاعلان';
        Notification::create([
            'subject' => $title,
            'message' => $messageData,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
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
            'verify' => 0
        ]);
        $messageData = 'تم حظر الاعلان الخاص بك برجاء التواصل مع الاداره ';
        $title = 'حظر الاعلان';
        Notification::create([
            'subject' => $title,
            'message' => $messageData,
            'user_id' => $ads->user_id,
            'product_id' => $ads->id,
        ]);
        $this->to($ads->user->device_token, $messageData, $title);
        $this->sendMail($ads->user, $ads, $messageData, $title);

        return back()->with('message', 'تم حظر الاعلان بنجاح');
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
        $subCategories = SubCategory::where('category_id', $request->category_id)->get();
        return json_encode($subCategories);
    }

}
