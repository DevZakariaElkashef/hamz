<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CarPushResource;
use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\ColorResource;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\FuelTypeResource;
use App\Http\Resources\Api\HomeResource;
use App\Http\Resources\Api\MarkaResource;
use App\Http\Resources\Api\ModelResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ProductStatusResource;
use App\Http\Resources\Api\TypeResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\SubCategoryResource;
use App\Http\Resources\Api\DirectionResource;
use App\Traits\GeneralTrait;
use App\Models\CarPush;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Direction;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\FuelType;
use App\Models\Marka;
use App\Models\ModelTypes;
use App\Models\Products;
use App\Models\ProductStatus;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function home()
    {
        try {
            $products = HomeResource::collection(Category::get())->toArray(request());

            $data = [];
            $data[0] = [
                'id' => 0,
                'name' => app()->getLocale() == 'ar' ? 'الكل' : 'All',
                'image' => "",
                'products' => ProductResource::collection(Products::latest()->get())
            ];

            // Merge the arrays
            $mergedData = array_merge($data, $products);

            return $this->returnData("data", ["products" => $mergedData], __('api.returnData'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function countries()
    {
        try {
            $countries = CountryResource::collection(Country::get());
            return $this->returnData("data", ["countries" => $countries], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function cities(Request $request)
    {
        try {
            $cities = CityResource::collection(City::where('country_id', $request->country_id)->get());
            return $this->returnData("data", ["cities" => $cities], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function categories(Request $request)
    {
        try {
            $categories = CategoryResource::collection(Category::get())->toArray(request());

            $data = [];
            $data[0] = [
                'id' => 0,
                'name' => app()->getLocale() == 'ar' ? 'الكل' : 'All',
                'image' => "",
                'subCategories' => []
            ];

            // Merge the arrays
            $mergedData = array_merge($data, $categories);

            return $this->returnData("data", ["categories" => $mergedData], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function otherCategories(Request $request)
    {
        try {
            $categories = CategoryResource::collection(Category::whereIn('id', [3,4,5,6])->get());
            return $this->returnData("data", ["categories" => $categories], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function subCategories(Request $request)
    {
        try {
            $subCategories = SubCategoryResource::collection(SubCategory::where('category_id', $request->category_id)->get());
            return $this->returnData("data", ["subCategories" => $subCategories], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function dataCar()
    {
        try {
            $marka = MarkaResource::collection(Marka::get());
            $models = ModelResource::collection(ModelTypes::get());
            $types = TypeResource::collection(Type::get());
            $colors = ColorResource::collection(Color::get());
            $fuelTypes = FuelTypeResource::collection(FuelType::get());
            $productStatus = ProductStatusResource::collection(ProductStatus::get());
            $carPush = CarPushResource::collection(CarPush::get());
            $directions = DirectionResource::collection(Direction::get());
            return $this->returnData("data", ["marka" => $marka, 'models' => $models, 'types' => $types, 'colors' => $colors, 'fuelTypes' => $fuelTypes, 'productStatus' => $productStatus, 'carPush' => $carPush, 'directions' => $directions], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function getModels(Request $request)
    {
        try {
            if($request->category_id)
            {
                $models = ModelResource::collection(ModelTypes::where('category_id', $request->category_id)->get());
            }
            else
            {
                $models = ModelResource::collection(ModelTypes::where('sub_category_id', $request->sub_category_id)->get());
            }
            return $this->returnData("data", ["models" => $models], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }


   public function filter(Request $request)
{
    try {
        $products = Products::query();

        // Filter by category if it's not 0
        if($request->category_id != 0) {
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

        // Handle sorting filters
        if ($request->filter_id) {
            if($request->filter_id == 1) {
                // Sort by price descending
                $products = $products->orderBy('price', 'DESC');
            }
            elseif($request->filter_id == 2) {
                // Sort by price ascending
                $products = $products->orderBy('price', 'ASC');
            }
            else {
                // Sort by distance using Haversine formula
                $latitude = $request->lat;      // User's latitude
                $longitude = $request->long;    // User's longitude
                $radius = 20000; // Radius in kilometers

                if($latitude && $longitude && $radius) {
                    $haversine = "(6371 * acos(cos(radians($latitude))
                                 * cos(radians(lat))
                                 * cos(radians(`long`) - radians($longitude))
                                 + sin(radians($latitude))
                                 * sin(radians(lat))))";

                    $products = $products->select('*') // Select all columns
                     ->addSelect(\DB::raw("$haversine AS distance_data")) // Add the distance calculation
                     ->having("distance_data", "<", $radius) // Filter by the calculated distance
                     ->orderBy("distance_data");
                }
            }
            $products = ProductResource::collection($products->paginate(30));
        }
        // Paginate the result and return it as a resource collection
        if(!$request->filter_id)
        {
            $products = ProductResource::collection($products->latest()->paginate(30));
        }

        return $this->returnData("data", ["products" => $products], __('api.returnData'));

    } catch (\Throwable $e) {
        return $this->returnError(403, $e->getMessage());
    }
}
}
