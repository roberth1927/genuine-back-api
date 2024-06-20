<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class DialogflowController extends Controller
{
    public function handleWebhook(Request $request)
    {
        \Log::info($request->all());

        $queryResult = $request->input('queryResult');
        $intentName = $queryResult['intent']['displayName'];
        $parameters = $queryResult['parameters'];

        switch ($intentName) {
            case 'GetAllCategories':
                return $this->getAllCategories();
            case 'GetCategoryById':
                $id = $parameters['id'];
                return $this->getCategoryById($id);
            case 'GetProductsInCategory':
                $id = $parameters['id'];
                return $this->getProductsInCategory($id);
            case 'GetProductCountInCategory':
                $id = $parameters['id'];
                return $this->getProductCountInCategory($id);
            default:
                return response()->json([
                    'fulfillmentText' => 'Intención no reconocida.'
                ]);
        }
    }

    private function getAllCategories()
    {
        $categories = Category::with('products')->get();
        $responseText = "Aquí están todas las categorías disponibles:\n";

        foreach ($categories as $category) {
            $responseText .= "\nCategoría: " . $category->name . "\n";
            $responseText .= "Descripción: " . $category->description . "\n";
            $responseText .= "Productos:\n";

            foreach ($category->products as $product) {
                $responseText .= "- " . $product->name . " (Cantidad: " . $product->quantity . ")\n";
            }
        }

        return response()->json([
            'fulfillmentText' => $responseText
        ]);
    }

    private function getCategoryById($id)
    {
        $category = Category::with('products')->find($id);
        if (!$category) {
            return response()->json([
                'fulfillmentText' => 'Category not found'
            ]);
        }
        return response()->json([
            'fulfillmentText' => $category->toJson()
        ]);
    }

    private function getProductsInCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'fulfillmentText' => 'Category not found'
            ]);
        }
        $products = $category->products;
        return response()->json([
            'fulfillmentText' => $products->toJson()
        ]);
    }

    private function getProductCountInCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'fulfillmentText' => 'Category not found'
            ]);
        }
        $count = $category->products->sum('quantity');
        return response()->json([
            'fulfillmentText' => "Hay $count productos en la categoría con ID $id."
        ]);
    }


}

