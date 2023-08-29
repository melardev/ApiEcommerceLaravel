<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // Make sure to adjust the namespace



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::put('/products/{id}', [ProductController::class, 'update']);

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
