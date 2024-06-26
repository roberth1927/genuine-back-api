<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\DialogflowController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::get('categories/{id}/product-count', [CategoryController::class, 'getProductCountInCategory']);
Route::get('categories/{id}/products', [CategoryController::class, 'getProductsInCategory']);

Route::post('/webhook', [DialogflowController::class, 'handleWebhook']);
