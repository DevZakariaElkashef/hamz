<?php

namespace App\Http\Controllers\Booth\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\ShowProductRecource;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function show(Product $product)
    {
        $product = new ShowProductRecource($product);

        return $this->sendResponse(200, $product);
    }
}
