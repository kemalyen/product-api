<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug', function () {

    $data = [
        'name' => 'Dell laptop Z3279482',
        'sku' => 'Z3279482',
        'barcode' => '89160083939393',
        'options' => ['Bag'],
        'option_values' => ['Bag' => 'Balck Soft'],
        'published_at' => '2023-10-23 10:42',
        'status' => 'true',
        'quantity' => 19,
        'price' => 105.30,
    ];
 
    $response = Http::post(
        'http://localhost:8000/api/products',
         $data
    );
    return $response;
});