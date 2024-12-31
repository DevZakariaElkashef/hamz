<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Section;
use App\Models\OrderItem;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\SliderResource;
use App\Http\Resources\Mall\SectionResource;
use App\Http\Resources\Mall\ProductInHomeResource;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponse, GeneralTrait;

    public function index()
    {
        $ad = Slider::mall()->fixed()->first();
        $mostSaledProductIds = OrderItem::mostSoldByApp('mall')->pluck('product_id')->toArray();
        $mostSaledProducts = Product::whereIn('id', $mostSaledProductIds)->get();

        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::mall()->active()->scrollable()->get()),
            'sections' => SectionResource::collection(Section::mall()->active()->with('stores')->latest()->take(4)->get()),
            'most_recent' => ProductInHomeResource::collection(Product::mall()->active()->latest()->take(4)->get()),
            'most_sale' => ProductInHomeResource::collection($mostSaledProducts),
        ];

        return $this->sendResponse(200, $data);
    }

    public function filter(Request $request)
    {
        try {
            $products = Product::query();

            $products = $products->mall();

            // Filter by category if it's not 0
            if ($request->category_id != 0) {
                $products = $products->where('category_id', $request->category_id);
            }

            // Apply filters for sub-category, country, and city
            $products = $products->when($request->sub_category_id, function ($query) use ($request) {
                return $query->where('sub_category_id', $request->sub_category_id);
            });

            $products = $products->when($request->country_id, function ($query) use ($request) {
                return $query->where('country_id', $request->country_id);
            });

            $products = $products->when($request->city_id, function ($query) use ($request) {
                return $query->where('city_id', $request->city_id);
            });

            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                // Assuming you're searching by product name or description
                $products = $products->where(function ($query) use ($searchTerm) {
                    $query->where('name_ar', 'like', "%{$searchTerm}%")
                        ->orWhere('name_en', 'like', "%{$searchTerm}%");
                        // ->orWhere('description', 'like', "%{$searchTerm}%"); // Add other fields as necessary
                });
            }
            // Handle sorting filters
            if ($request->filter_id) {
                if ($request->filter_id == 3) { //'price', 'DESC' => 3,'price', 'ASC' => 2, 'date', 'DESC' => any thing
                    // Sort by price descending
                    $products = $products->orderBy('price', 'DESC');
                } elseif ($request->filter_id == 2) {
                    // Sort by price ascending
                    $products = $products->orderBy('price', 'ASC');
                } else {
                    $products = $products->orderBy('created_at', 'DESC');
                    // $latitude = $request->lat;      // User's latitude
                    // $longitude = $request->long;    // User's longitude
                    // $radius = 20000; // Radius in kilometers
                    // if ($latitude && $longitude && $radius) {
                    //     $haversine = "(6371 * acos(cos(radians($latitude))
                    //              * cos(radians(lat))
                    //              * cos(radians(`long`) - radians($longitude))
                    //             + sin(radians($latitude))
                    //              * sin(radians(lat))))";

                    //     $products = $products->select('*') // Select all columns
                    //         ->addSelect(\DB::raw("$haversine AS distance_data")) // Add the distance calculation
                    //         ->having("distance_data", "<", $radius) // Filter by the calculated distance
                    //         ->orderBy("distance_data");
                    // }
                }
                $products = ProductInHomeResource::collection($products->paginate(30));
            }

            // Paginate the result and return it as a resource collection
            if (!$request->filter_id) {
                $products = ProductInHomeResource::collection($products->latest()->paginate(30));
            }

            return $this->returnData("data", ["products" => $products], __('main.returnData'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
