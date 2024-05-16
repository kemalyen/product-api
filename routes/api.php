<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::apiResources([
    'products' => ProductController::class,
]);

Route::apiResources([
    'categories' => CategoryController::class,
]);

/* Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'products' => ProductController::class,
    ]);
}); */

Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/token', [TokenController::class, 'create'])->name('token');