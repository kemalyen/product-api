<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\TokenController;
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




Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'products' => ProductController::class,
    ]);

    Route::apiResources([
        'categories' => CategoryController::class,
    ]);


    Route::apiResources([
        'accounts' => AccountController::class,
    ]);

    Route::apiResources([
        'users' => UserController::class,
    ]);
});

 
Route::post('/token', [TokenController::class, 'create'])->name('token');