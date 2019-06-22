<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication
Route::post('/signin', 'AuthController@signin');

//Registration
Route::post('/register', 'AuthController@register');

//Sign Out
Route::middleware('auth:api')->post('/signout', 'AuthController@signout');

//List All Categories
Route::get('categories', 'CategoriesController@index');

//Create New Category
Route::post('category', 'CategoriesController@store');

//Update Category
Route::put('category', 'CategoriesController@store');

//Delete Category
Route::delete('category/{id}', 'CategoriesController@destroy');

//List All Gallery
Route::get('gallery', 'GalleryController@index');

//List All Active Gallery
Route::get('active_gallery', 'GalleryController@active');

//List Single in Gallery
Route::get('build/{id}', 'GalleryController@show');

//List All Orders
Route::get('orders', 'OrdersController@index');

//List Single Orders
Route::get('order/{invoice}', 'OrdersController@show');

//List All Pending Orders
Route::get('pending_orders', 'OrdersController@pending');

//List All Approved Orders
Route::get('approved_orders', 'OrdersController@approved');

//Get Last Invoice
Route::get('last_invoice', 'OrdersController@last_invoice');

//Submit Order
Route::post('order', 'OrdersController@store');

//List All Products
Route::get('products', 'ProductsController@index');

//List All Active Products
Route::get('active_products', 'ProductsController@active');

//List All Critical Products
Route::get('critical_products', 'ProductsController@critical_products');

//List All Featured Products
Route::get('featured', 'ProductsController@featured');

//List All Filtered Active Products
Route::get('filter_products/{id}', 'ProductsController@filter');

//List All Searched Active Products
Route::get('search_product/{value}', 'ProductsController@search_product');

//List Single Product
Route::get('product/{id}', 'ProductsController@show');

//Create New Product
Route::post('product', 'ProductsController@store');

//Update Product
Route::put('product', 'ProductsController@store');

//Delete Product
Route::delete('product/{id}', 'ProductsController@destroy');

//Receive Stock
Route::put('receive', 'ProductsController@receive');

//Remove Stock
Route::put('remove', 'ProductsController@remove');
