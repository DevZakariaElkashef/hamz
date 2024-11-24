<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use App\Repositories\FatoorahRepository;
use Illuminate\Http\Request;

class SubscripeController extends Controller
{

    public $fatoorahRepository;

    public function __construct(FatoorahRepository $fatoorahRepository)
    {
        $this->fatoorahRepository = $fatoorahRepository;
    }

    public function create(Request $request)
    {
        $packages = Package::active()->earn()->get();
        return view('earn.subscripe.create', compact('packages'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::find($request->package_id);

        $data = [
            "CustomerName" => "Test User",
            "NotificationOption" => 'LNK',
            "InvoiceValue" => $package->price,
            "CustomerEmail" => "email@email.com",
            "CallBackUrl" => route("earn.subscripe.callback"),
            "ErrorUrl" => route("earn.subscripe.error"),
            "Language" => app()->getLocale(),
            "DisplayCurrencyIso" => 'SAR',
            'CustomerReference' => $request->package_id . '-' . 1,
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
                Subscription::create([
                    'user_id' => $userId,
                    'package_id' => $packageId,
                    'status' => 1,
                    'transaction_id' => $request->paymentId,
                ]);
            }
        }
        return redirect()->route('earn.subscripe.success');
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