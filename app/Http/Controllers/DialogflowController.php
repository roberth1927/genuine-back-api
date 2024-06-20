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

            case 'GetProductCountInCategory':
                $id = $parameters['id'];
                return $this->getProductCountInCategory($id);

            case 'GetProductsInCategory':
                $id = $parameters['id'];
                return $this->getProductsInCategory($id);

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
                'fulfillmentText' => 'No se encontró la categoría.'
            ]);
        }

        $responseText = "Información de la categoría:\n";
        $responseText .= "ID: " . $category->id . "\n";
        $responseText .= "Nombre: " . $category->name . "\n";
        $responseText .= "Descripción: " . $category->description . "\n";

        return response()->json([
            'fulfillmentText' => $responseText
        ]);
    }

    private function getProductCountInCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'fulfillmentText' => 'No se encontró la categoría con el ID proporcionado.'
            ]);
        }

        $count = $category->products->sum('quantity');

        $responseText = "Número de productos en la categoría " . $category->name . ": " . $count;

        return response()->json([
            'fulfillmentText' => $responseText
        ]);
    }

    private function getProductsInCategory($id)
    {
        $category = Category::with('products')->find($id);
        if (!$category) {
            return response()->json([
                'fulfillmentText' => 'No se encontró la categoría con el ID proporcionado.'
            ]);
        }

        $responseText = "Productos en la categoría " . $category->name . ":\n";

        if ($category->products->isNotEmpty()) {
            foreach ($category->products as $product) {
                $responseText .= "- " . $product->name . ": " . $product->description . " (Cantidad: " . $product->quantity . ")\n";
            }
        } else {
            $responseText .= "No hay productos disponibles en esta categoría.\n";
        }

        return response()->json([
            'fulfillmentText' => $responseText
        ]);
    }




}

