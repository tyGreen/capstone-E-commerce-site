<?php

use Illuminate\Support\Facades\Route;

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

// Routes for items & categories accesible only to authenticated users
Route::resource('items', '\App\Http\Controllers\ItemController')->middleware('auth');
Route::resource('categories', '\App\Http\Controllers\CategoryController')->middleware('auth');

// Public route for public store (product) pages
Route::resource('products', '\App\Http\Controllers\ProductController');
Route::get('/products/details/{id}', '\App\Http\Controllers\ProductController@details')->name('products.details');

// Session Controller routes
Route::get('/sessions/getData/{request}', '\App\Http\Controllers\SessionController@getData')->name('session.getData');
Route::get('/sessions/createNew', '\App\Http\Controllers\SessionController@createNew')->name('session.createNew');

// Cart Routes
Route::get('/cart/index', '\App\Http\Controllers\CartController@index')->name('cart.index');
Route::get('/cart/addToCart/{id}', '\App\Http\Controllers\CartController@addToCart')->name('cart.addToCart');
Route::put('/cart/update_cart/{id}', '\App\Http\Controllers\CartController@update_cart')->name('cart.update_cart');
Route::get('/cart/remove_item/{id}', '\App\Http\Controllers\CartController@remove_item')->name('cart.remove_item');




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
