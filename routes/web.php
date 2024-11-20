<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('login');
});


Route::group(['middleware' => 'check.user.data'], function () {
  
    Route::get('/products', [ProductsController::class, 'getList'])->name('products');
    Route::get('/getProducts/{addId}', [ProductsController::class, 'getItem'])->name('getProducts');
    Route::post('productsCreate', [ProductsController::class, 'create'])->name('productsCreate');
    Route::delete('/deleteProducts/{addId}', [ProductsController::class, 'deleteProducts'])->name('deleteProducts');
    Route::any('productEdit', [ProductsController::class, 'edit'])->name('productEdit');

    Route::get('/review', [ReviewController::class, 'getList'])->name('review');
    Route::delete('/deleteHighlightedProducts/{Id}', [ReviewController::class, 'deleteHighlightedProducts'])->name('deleteHighlightedProducts');


});


Route::get('/users', [ProductsController::class, 'index']); // To load the Select2 page


//Login URLS---->>
Route::get('/login', [PackageController::class, 'login'])->name('login');

Route::post('loginSubmit', [PackageController::class, 'loginSubmit'])->name('loginSubmit');

Route::get('logout', [PackageController::class, 'logout'])->name('logout');
