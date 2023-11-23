<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\showProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

// route::get('post',[HomeController::class,'post'])->middleware(['auth', 'admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// routes/web.php
// routes/web.php

// Route::middleware(['auth', 'usertype:user'])->group(function () {
//     // Routes that only "user" can access
//     Route::get('/user-only', 'UserController@index');
//     // Add your user-specific routes here
// });

// Route::middleware(['auth', 'usertype:admin'])->group(function () {
//     // Routes that only "admin" can access
//     Route::get('/admin-only', 'AdminController@index');
//     // Add your admin-specific routes here
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart/add/{product}', 'CartController@addToCart')->name('cart.addToCart');
    Route::post('/cart/update', 'CartController@updateCart')->name('cart.updateCart');
    Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
});


Route::resource('/products', ProductController::class)->middleware(['auth','admin']);
Route::resource('/showProducts', showProductController::class)->middleware(['auth','user']);
Route::resource('/cart', CartController::class)->middleware(['auth','user']);
Route::resource('/orders', OrdersController::class)->middleware(['auth','user']);
Route::post('/cart/remove/{cartItem}', 'CartController@remove')->name('cart.remove');
Route::post('/orders', 'OrdersController@store')->name('orders.store');

Route::get('/orders', function () {
    return view('orders.index');
})->name('orders.index');


// Route::post('/cart/add/{product}', 'CartController@addToCart')->name('cart.add');
// Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.addToCart');
Route::patch('/cart/{cartItem}', 'CartController@update')->name('cart.update');

// Route::post('/cart/add/{product}', 'CartController@addToCart')->name('cart.add');
Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');
Route::delete('/products/{id}', 'ProductController@destroy')->name('products.destroy');


require __DIR__.'/auth.php';
