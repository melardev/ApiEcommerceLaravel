<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['cors-m',  'jwt.check'])->group(function () {

    // Home
    Route::get('', 'PageController@home');

    // Register/Login
    Route::post('/users', 'AuthApiController@register');
    Route::post('/users/login', 'AuthApiController@login');
    Route::post('/auth/login', 'AuthApiController@login');


    // ====================
    // ==    Orders      ==
    // ====================
    Route::get('orders', 'OrderController@index');
    Route::resource('orders', 'OrderController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    // ====================
    // ==    Products    ==
    // ====================

    Route::resource('products', 'ProductController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    Route::get('products/by_id/{id}', 'ProductController@getById');

    Route::get('products/by_tag/{tag_name}', 'ProductController@getByTag');
    Route::get('products/by_category/{tag_name}', 'ProductController@getByCategory');

    // Comments
    Route::resource('products.comments', 'CommentController');

    // Tags
    Route::resource('tags', 'TagsController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    // Categories
    Route::resource('categories', 'CategoriesController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    // Addresses
    Route::get('addresses', 'ProfileController@getMyAddresses');


});