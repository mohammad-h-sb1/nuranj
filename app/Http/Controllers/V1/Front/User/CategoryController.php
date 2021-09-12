<?php

namespace App\Http\Controllers\V1\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::all();
        return response()->json([
            'status'=>'ok',
            'data'=>CategoryResource::collection($category)
        ]);
    }

    public function show($id)
    {
        $category=Category::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new CategoryResource($category)
        ]);
    }
}
