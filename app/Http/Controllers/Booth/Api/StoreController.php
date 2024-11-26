<?php

namespace App\Http\Controllers\Booth\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\ShowStoreRecource;
use App\Http\Resources\Booth\StoreRecource;
use App\Traits\ApiResponse;

class StoreController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $stores = StoreRecource::collection(Store::booth()->active()->get());

        return $this->sendResponse(200, $stores);
    }

    public function show(Store $store)
    {
        $store = new ShowStoreRecource($store);

        return $this->sendResponse(200, $store);
    }
}
