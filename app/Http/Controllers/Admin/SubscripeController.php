<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Video;
use App\Repositories\FatoorahRepository;
use Illuminate\Http\Request;

class SubscripeController extends Controller
{

    public $fatoorahRepository;

    public function __construct(Request $request, FatoorahRepository $fatoorahRepository)
    {
        $this->fatoorahRepository = $fatoorahRepository;
    }

    public function create(Request $request, $video_id)
    {
        // if(isUserSubscribed($request->user(), 'earn')){
        //     return redirect()->route('earn.home');
        // }

        $packages = Package::active()->earn()->get();
        return view('earn.subscripe.create', compact('packages', 'video_id'));
    }

    public function store(Request $request, $video_id)
    {

        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::find($request->package_id);

        $userID = $request->user()->id;

        $data = [
            "CustomerName" => $request->user()->name,
            "NotificationOption" => 'LNK',
            "InvoiceValue" => $package->price,
            "CustomerEmail" => $request->user()->email,
            "CallBackUrl" => route("earn.subscripe.callback"),
            "ErrorUrl" => route("earn.subscripe.error"),
            "Language" => app()->getLocale(),
            "DisplayCurrencyIso" => 'SAR',
            'CustomerReference' => $request->package_id . '-' . $userID . '-' . $video_id,
        ];

        $response = $this->fatoorahRepository->sendPayment($data);
        $invoiceUrl = $response['Data']['InvoiceURL'];

        // Remove backslashes from the URL
        $cleanedUrl = str_replace('\\', '', $invoiceUrl);

        // Redirect the user to the cleaned URL
        return redirect()->away($cleanedUrl);

    }

    public function callBack(Request $request)
    {
        $data['Key'] = $request->paymentId;
        $data['KeyType'] = 'paymentId';

        $response = $this->fatoorahRepository->GetPaymentStatus($data);

        if ($response['Data']['CustomerReference']) {
            $packageId = explode('-', $response['Data']['CustomerReference'])[0];
            $userId = explode('-', $response['Data']['CustomerReference'])[1];
            $video_id = explode('-', $response['Data']['CustomerReference'])[2];

            if ($packageId && $userId && $video_id) {
                $package = Package::findOrFail($packageId);
                $date = date('Y-m-d', strtotime(date('Y-m-d') . "+ $package->period_in_days days"));
                Subscription::create([
                    'user_id' => $userId,
                    'video_id' => $video_id,
                    'package_id' => $packageId,
                    'limit' => $package->limit,
                    'expire_date' => $date,
                    'status' => 1,
                    'transaction_id' => $request->paymentId,
                    'app' => 'earn'
                ]);
                $video = Video::findOrFail($video_id);
                if ($video) {
                    $video->package_id  = $package->id;
                    $video->reword_amount = $package->reword_amount;
                    $video->payment_status = 1;
                    $video->save();
                }
            }
        }

        session()->flash('success', __('main.subscription_success'));
        return redirect()->route('earn.home');
    }

    public function error()
    {
        return 'Something went wrong';
    }

    public function success()
    {
        return 'Subscription Compelete';
    }
}
