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

    public function show($store_id)
    {
        $store = Store::mall()->find($store_id);
        if (!$store) {
            return $this->sendResponse(404, null,__( 'main.store_id_exists' ));
        }
        $store = new ShowStoreRecource($store);

        return $this->sendResponse(200, $store);
    }
}
