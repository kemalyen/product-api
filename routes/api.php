<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/products/{product}/variants', [ProductController::class, 'variants'])->name('product.variants');
Route::post('/products/{product}/variants', [ProductController::class, 'create_variant'])->name('product.create_variant');
//Route::get('/products/{product}/stock', [ProductController::class, 'variants'])->name('product.stock');
//Route::get('/products/{product}/price', [ProductController::class, 'variants'])->name('product.price');
 
Route::apiResources([
    'products' => ProductController::class,
]);
