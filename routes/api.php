<?php

use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\DeliveryApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;


Route::post("/login", [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register'])->name('register.submit');
Route::get('product/index',[ ProductApiController::class,"page"]);

Route::middleware('auth:sanctum')->group(function(){
    Route::delete('product/{id}', [ProductApiController::class, 'delete']);
    Route::resource('product', ProductApiController::class);

    // Logout
    Route::post('logout', [AuthApiController::class, 'logout'])->name('logout');


    Route::get('customer/cart', [CustomerApiController::class, 'cart']);
    Route::post('cart/add_in_cart/{productId}', [CustomerApiController::class, 'addToCart']);
    Route::delete('cart/remove_product/{productId}', [CustomerApiController::class, 'removeFromCart']);
    Route::post('cart/buy_order/{cartId}', [CustomerApiController::class, 'buy']);
    Route::get('customer/cancel_order/{id}', [CustomerApiController::class, 'cancel']);
    Route::get('customer/received/{id}', [CustomerApiController::class, 'received']);
    Route::get('customer/order', [CustomerApiController::class, 'orders']);
    Route::get('customer/search/product', [CustomerApiController::class, 'search']);
    // Delivery
    // -------------------------------
    Route::get('delivery/money/{id}', [DeliveryApiController::class, 'collectMoney']);
    Route::get('delivery/past', [DeliveryApiController::class, 'pastOrders']);
    Route::get('delivery', [DeliveryApiController::class, 'orders']);
    Route::get('delivery/work', [DeliveryApiController::class, 'myOrders']);
    Route::get('delivery/add/{id}', [DeliveryApiController::class, 'takeOrder']);
    Route::get('delivery/delivered/{id}', [DeliveryApiController::class, 'delivered']);
    Route::get('delivery/{id}', [DeliveryApiController::class, 'details']);

Route::post('user/update', [CustomerApiController::class, 'Update']);
    // Admin
    // -------------------------------
    Route::post('delivery', [AdminApiController::class, 'Delivery']);
    Route::get('admin/deliveries', [AdminApiController::class, 'deliveries']);
    Route::get('admin/deliveries/{id}', [AdminApiController::class, 'details']);
    Route::get('admin/orders', [AdminApiController::class, 'orders']);
    Route::get('admin/money/{id}', [AdminApiController::class, 'money']);
    Route::get('admin/search/order', [AdminApiController::class, 'search']);
    Route::get('admin/search/delivery', [AdminApiController::class, 'search_delivery']);
    Route::get('admin/product/delete', [AdminApiController::class, 'delete']);
    Route::get('admin/product/active/{id}', [AdminApiController::class, 'active']);

    // Product Stock
    // -------------------------------
    Route::get('product/AddStock/{id}', [ProductApiController::class, 'AddStock']);
    Route::get('product/RemoveStock/{id}', [ProductApiController::class, 'RemoveStock']);

});