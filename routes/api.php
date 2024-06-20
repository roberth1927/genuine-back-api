<?php

use App\Http\Controllers\Api\CategoryController;

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::get('categories/{id}/products', [CategoryController::class, 'getProductsInCategory']);
Route::get('categories/{id}/product-count', [CategoryController::class, 'getProductCountInCategory']);
