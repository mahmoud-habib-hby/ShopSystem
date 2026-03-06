<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
Route::get('/', function () {
    return view('welcome');
});



Route::resource('product', ProductController::class);

// صفحة تسجيل الدخول
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::get('Delivery', [AdminController::class, 'DeliveryForm'])->name('Delivry.form');
Route::post('Delivery', [AdminController::class, 'Delivery'])->name('Delivry.add');
Route::get('delivery/past',[DeliveryController::class, 'past'])->name('delivery.past');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('customer',[CustomerController::class, 'index'])->name('customer.index');
Route::get('customer/cart',[CustomerController::class, 'cart'])->name('customer.cart');
Route::get('customer/order',[CustomerController::class, 'order'])->name('customer.order');
Route::get('customer/received/{id}',[CustomerController::class, 'received'])->name('customer.received');
Route::get('/cart/add/{productId}', [CustomerController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{productId}', [CustomerController::class, 'removeFromCart'])->name('cart.remove');
Route::get('delivery/work',[DeliveryController::class, 'work'])->name('delivery.work');
Route::Post('cart/buy/{cartId}',[CustomerController::class, 'buy'])->name('cart.buy');
Route::get('delivery',[DeliveryController::class, 'index'])->name('delivery.index');
Route::get('delivery/{id}',[DeliveryController::class, 'show'])->name('delivery.show');
Route::get('delivery/add/{id}',[DeliveryController::class, 'add'])->name('delivery.add');
Route::get('delivery/delivered/{id}',[DeliveryController::class, 'delivered'])->name('delivery.delivered');
Route::get('admin/deliveries',[AdminController::class, 'deliveries'])->name('admin.deliveries');
Route::get('admin/deliveries/{id}',[AdminController::class, 'details'])->name('admin.details');

