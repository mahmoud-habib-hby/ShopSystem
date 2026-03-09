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



    Route::delete('product/{id}', [ProductController::class, 'delete']);
    Route::resource('product', ProductController::class);
// صفحة تسجيل الدخول
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('customer/cancel/{id}',[CustomerController::class, 'cancel'])->name('customer.cancel');
Route::get('customer/cart',[CustomerController::class, 'cart'])->name('customer.cart');
Route::get('customer',[CustomerController::class, 'index'])->name('customer.index');
Route::get('/cart/add/{productId}', [CustomerController::class, 'addToCart'])->name('cart.add');
Route::get('customer/received/{id}',[CustomerController::class, 'received'])->name('customer.received');
Route::delete('/cart/remove/{productId}', [CustomerController::class, 'removeFromCart'])->name('cart.remove');
Route::Post('cart/buy/{cartId}',[CustomerController::class, 'buy'])->name('cart.buy');
Route::get('customer/search/prduct',[CustomerController::class, 'search'])->name('customer.search'); 
Route::get('customer/order',[CustomerController::class, 'order'])->name('customer.order');


Route::get('Delivery', [AdminController::class, 'DeliveryForm'])->name('Delivry.form');
Route::get('delivery/money/{id}',[DeliveryController::class, 'money'])->name('delivery.money');
Route::get('delivery/past',[DeliveryController::class, 'past'])->name('delivery.past');
Route::post('Delivery', [AdminController::class, 'Delivery'])->name('Delivry.add');
Route::get('delivery',[DeliveryController::class, 'index'])->name('delivery.index');
Route::get('delivery/work',[DeliveryController::class, 'work'])->name('delivery.work');
Route::get('delivery/add/{id}',[DeliveryController::class, 'add'])->name('delivery.add');
Route::get('delivery/delivered/{id}',[DeliveryController::class, 'delivered'])->name('delivery.delivered');
Route::get('delivery/{id}',[DeliveryController::class, 'show'])->name('delivery.show');


Route::get('admin/deliveries',[AdminController::class, 'deliveries'])->name('admin.deliveries');
Route::get('admin/product/delete',[AdminController::class, 'delete'])->name('product.delete');
Route::get('admin/product/active/{id}',[AdminController::class, 'active'])->name('product.active');

Route::get('admin/orders',[AdminController::class, 'orders'])->name('admin.orders');
Route::get('admin/deliveries/{id}',[AdminController::class, 'details'])->name('admin.details');
Route::get('admin/money/{id}',[AdminController::class, 'money'])->name('admin.money');
Route::get('admin/search/order',[AdminController::class, 'search'])->name('admin.search');  
Route::get('admin/search/delivery',[AdminController::class, 'search_delivery'])->name('admin.search_delivery');  
Route::get('product/AddStock/{id}',[ProductController::class, 'AddStock'])->name('add.stock');  
Route::get('product/RemoveStock/{id}',[ProductController::class, 'RemoveStock'])->name('remove.stock');  
