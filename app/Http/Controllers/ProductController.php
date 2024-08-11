<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductProperties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    public function index() 
    {
        return Product::with('properties')->get();
    }

    public function filteredIndex(Request $request)
    {
        if (!$request->has('properties')) {
            return response()->json('no filter params', 500);
        }
        $properties = $request->query('properties');

        $ids = [];
        foreach ($properties as $key => $value) {
            $rawCurrentIds = DB::table('products')
                ->join('product_properties', 'products.id', '=', 'product_properties.product_id', 'left')
                ->where('key', $key)
                ->where(function ($query) use ($value) {
                    foreach (['int', 'float', 'bool', 'string'] as $type) {
                        $query->orWhere(function($query) use ($type, $value) {
                            $valueType = "{$type}_value";
                            $query->whereNotNull($valueType)->where($valueType, $value);
                        });
                    }
                })
                ->select('products.id')
                ->distinct()
                ->get();

            $currentIds = [];
            foreach ($rawCurrentIds as $cId) {
                $currentIds[] = $cId->id;
            }
            $ids[] = $currentIds;
        }
        $intersectIds = array_intersect(...$ids);
        return Product::whereIn('id', $intersectIds)
            ->with('properties')
            ->paginate(40)
            ->withQueryString();
    }

    public function generate() 
    {
        if (Product::count()) {
            return response()->json('products already generated');
        }
        return Product::factory()
            ->count(60)
            ->has(ProductProperties::factory()->count(4), 'properties')
            ->create();
    }
}
