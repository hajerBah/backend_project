<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

class BrandController extends Controller
{

    public function getSuppliersByCategory($category = null)
    {
        $categoryId = $category ?? auth()->user()->category_id;
        
     
        $suppliers = Supplier::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        })->paginate(10);

        if ($category && $category !==  auth()->user()->category_id && !$suppliers->isEmpty()) {
            auth()->user()->searchHistories()->create(['terms' => $category]);
        }

        return SupplierResource::collection($suppliers);
    }


    public function getProductsBySupplier(Supplier $supplier)
    {
        $products = $supplier->products()->with('settings','category','supplier')->paginate(10);
        
        return ProductResource::collection($products);
    }
}
