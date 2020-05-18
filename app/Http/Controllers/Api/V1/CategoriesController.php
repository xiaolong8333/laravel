<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Api\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
}
