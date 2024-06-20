<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('products')->get();
    }

    public function show($id)
    {
        $category = Category::with('products')->find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return $category;
    }

    public function getProductsInCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return $category->products;
    }

    public function getProductCountInCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $count = $category->products->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
