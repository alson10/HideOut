<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\showProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ManageOrdersController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
// Route::get('/home', [HomeController::class, 'index'])->middleware('auth', 'user')->name('home');
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth','admin')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.updateCart');
    Route::get('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

});

Route::resource('/dashboard', DashboardController::class)->middleware(['auth','admin']);

Route::resource('/products', ProductController::class)->middleware(['auth']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/showProducts/index', [showProductController::class, 'index'])->name('showProducts.index');

Route::resource('/showProducts', showProductController::class)->middleware(['auth', 'user']);
Route::resource('/cart', CartController::class)->middleware(['auth', 'user']);
Route::resource('/manageOrders', ManageOrdersController::class)->middleware(['auth','admin']);
Route::get('/manage-orders', [ManageOrdersController::class, 'index'])->name('manageOrders.index');
Route::post('/update-status/{orderId}', [ManageOrdersController::class, 'updateStatus'])->name('update-status');
Route::get('/', [ProductController::class, 'getPackages'])->name('welcome');


Route::get('/orders', [OrdersController::class, 'index'])->middleware(['auth', 'user'])->name('orders.index');
Route::post('/orders', [OrdersController::class, 'store'])->middleware(['auth', 'user'])->name('orders.store');
Route::post('/orders/{orders}/cancel', [OrdersController::class, 'cancel'])->name('orders.cancel');

require __DIR__.'/auth.php';
