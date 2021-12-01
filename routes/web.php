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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group([ 'prefix' => 'admin', 'middleware' => 'is_admin' ], function (){

    Route::get('/home', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('attributes', \App\Http\Controllers\Admin\AttributeController::class);
    Route::resource('options', \App\Http\Controllers\Admin\OptionController::class);

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    Route::get('/getAttributes', [App\Http\Controllers\Admin\ProductController::class, 'getAttributes']);
    Route::get('/getBrands', [App\Http\Controllers\Admin\ProductController::class, 'getBrands']);
    Route::get('/getCategories', [App\Http\Controllers\Admin\ProductController::class, 'getCategories']);
});

