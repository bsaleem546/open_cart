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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::group([ 'prefix' => 'admin', 'middleware' => 'is_admin' ], function (){

    Route::get('/home', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('attributes', \App\Http\Controllers\Admin\AttributeController::class);
    Route::resource('options', \App\Http\Controllers\Admin\OptionController::class);

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/featured', [\App\Http\Controllers\Admin\ProductController::class, 'featured']);

    Route::get('/getAttributes', [App\Http\Controllers\Admin\ProductController::class, 'getAttributes']);
    Route::get('/getBrands', [App\Http\Controllers\Admin\ProductController::class, 'getBrands']);
    Route::get('/getCategories', [App\Http\Controllers\Admin\ProductController::class, 'getCategories']);

    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::resource('shippings', \App\Http\Controllers\Admin\ShippingController::class);

    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);

    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('customers', [\App\Http\Controllers\Admin\OrderController::class, 'allCustomers'])->name('orders.customers');
    Route::get('order-details/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'orderDetails'])->name('orders.details');
    Route::post('order-status', [\App\Http\Controllers\Admin\OrderController::class, 'orderStatus'])->name('orders.status');

    Route::resource('home-section-1', \App\Http\Controllers\Admin\HomeSectionController::class);

    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('review', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus']);

    Route::resource('popups', \App\Http\Controllers\Admin\PopupController::class);

});


Route::get('categories/{slug}', [App\Http\Controllers\HomeController::class, 'getCategoryBySlug']);
Route::get('categories', [App\Http\Controllers\HomeController::class, 'allCategories']);
Route::get('products', [App\Http\Controllers\HomeController::class, 'allProducts']);
Route::get('products/{slug}', [App\Http\Controllers\HomeController::class, 'getProductBySlug']);
Route::post('addToCart', [App\Http\Controllers\HomeController::class, 'addToCart']);
Route::get('addToWishlist/{id}', [App\Http\Controllers\HomeController::class, 'addToWishlist']);
Route::get('cart', [App\Http\Controllers\HomeController::class, 'viewCart']);
Route::get('checkCoupon/{coupon}', [App\Http\Controllers\HomeController::class, 'checkCoupon']);
Route::get('removeItem/{id}', [App\Http\Controllers\HomeController::class, 'removeItem']);
Route::get('addCartSession/{total}/{discount}/{ship}/{finalTotal}/{discountCode}', [App\Http\Controllers\HomeController::class, 'addCartSession']);
Route::get('checkout', [App\Http\Controllers\HomeController::class, 'checkout']);
Route::post('addCustomerDetails', [App\Http\Controllers\HomeController::class, 'addCustomerDetails']);
Route::get('checkout-details', [App\Http\Controllers\HomeController::class, 'checkoutDetails']);
Route::post('confirm-order', [App\Http\Controllers\HomeController::class, 'confirmOrder']);
Route::get('order-completed/{id}', [App\Http\Controllers\HomeController::class, 'orderCompleted']);

Route::get('order-tracking', [App\Http\Controllers\HomeController::class, 'orderTracking']);
Route::post('order-tracking', [App\Http\Controllers\HomeController::class, 'orderTrackingGet']);


Route::post('post-review', [App\Http\Controllers\ReviewController::class, 'postReview']);

Route::get('about-us', [App\Http\Controllers\HomeController::class, 'about']);
Route::get('contact-us', [App\Http\Controllers\HomeController::class, 'contact']);
Route::get('terms-and-conditions', [App\Http\Controllers\HomeController::class, 'termAndConditions']);


Route::get('send-mails', [\App\Http\Controllers\CronController::class, 'sendMail']);

//Route::get('/', function (){
//    return view('orderCompleted');
//});

