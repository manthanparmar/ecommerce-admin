<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductsController::class, 'getProducts'])->name('products');

Route::post('/insertToCart', [PackageController::class, 'insertToCart']);

Route::get('/cart/{userId}', [PackageController::class, 'getCartData']);

Route::put('/updateCart/{cartId}', [PackageController::class, 'updateCart']);


Route::put('/cart/{cartId}', [PackageController::class, 'updateCart']);


Route::get('/getProduct/{productId}', [ProductsController::class, 'getProductDetail']);


Route::post('/submitReview', [ReviewController::class, 'submitReview']);


// Route::prefix('autocomplete')->group(function () {
//     Route::get('getCategories', 'CategoryController@getCategories');
// });