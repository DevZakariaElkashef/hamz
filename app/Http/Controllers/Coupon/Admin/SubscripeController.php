<?php

namespace App\Http\Controllers\Coupon\Admin;

use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FatoorahRepository;

class SubscripeController extends Controller
{
    public $fatoorahRepository;

    public function __construct(FatoorahRepository $fatoorahRepository)
    {
        $this->fatoorahRepository = $fatoorahRepository;
    }

    public function create(Request $request)
    {
        abort_if(isUserSubscribed($request->user(), 'coupons'), 404);

        $packages = Package::active()->coupon()->get();
        return view('coupon.subscripe.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::find($request->package_id);

        $userID = $request->user()->id;

        $data = [
            "CustomerName" => "Test User",
            "NotificationOption" => 'LNK',
            "InvoiceValue" => $package->price,
            "CustomerEmail" => "email@email.com",
            "CallBackUrl" => route("coupon.subscripe.callback"),
            "ErrorUrl" => route("coupon.subscripe.error"),
            "Language" => app()->getLocale(),
            "DisplayCurrencyIso" => 'SAR',
            'CustomerReference' => $request->package_id . '-' . $userID,
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

            if ($packageId && $userId) {
                $package = Package::findOrFail($packageId);
                $date = date('Y-m-d', strtotime(date('Y-m-d') . "+ $package->period_in_days days"));
                Subscription::create([
                    'user_id' => $userId,
                    'package_id' => $packageId,
                    'limit' => $package->limit,
                    'expire_date' => $date,
                    'status' => 1,
                    'transaction_id' => $request->paymentId,
                    'app' => 'coupons'
                ]);
            }
        }

        session()->flash('success', __('main.subscription_success'));
        return redirect()->route('coupon.home');
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
