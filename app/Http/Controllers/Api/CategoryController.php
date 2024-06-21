<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Categorías recuperadas exitosamente',
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Categoria no encontrada',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Categoría recuperada exitosamente',
            'data' => $category
        ], 200);
    }

    public function getProductCountInCategory($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID de categoría no proporcionado o no válido',
                'data' => null
            ], 400);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Categoría no encontrada',
                'data' => null
            ], 404);
        }

        $count = $category->products->sum('quantity');

        return response()->json([
            'status' => 'success',
            'message' => 'Cantidad de productos en la categoría recuperada exitosamente',
            'data' => [
                'category_id' => $id,
                'category_name' => $category->name,
                'product_count' => $count,
                'friendly_message' => "El total de productos en la categoría '{$category->name}' es de {$count}."
            ]
        ], 200);
    }

    public function getProductsInCategory($id)
    {
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID de categoría no proporcionado o no válido',
                'data' => null
            ], 400);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Categoría no encontrada',
                'data' => null
            ], 404);
        }

        $products = $category->products;

        return response()->json([
            'status' => 'success',
            'message' => 'Productos de la categoría recuperados exitosamente',
            'data' => [
                'category_id' => $id,
                'category_name' => $category->name,
                'products' => $products,
                'friendly_message' => "Se han recuperado " . count($products) . " productos en la categoría '{$category->name}'."
            ]
        ], 200);
    }
}
