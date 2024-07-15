<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\Category;
use App\Models\Color;

class GeneralController extends Controller
{

    public function getAllCategories()
    {
        $categories = Category::select('id', 'name')->get();
        return GeneralResource::collection($categories);
    }
    public function getAllColors()
    {
        $colors = Color::select('id', 'name')->get();
        return GeneralResource::collection($colors);
    }

}
