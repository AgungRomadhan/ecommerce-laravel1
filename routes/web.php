<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;

// Guest Route
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');
    
    Route::post('/post-login', [AuthController::class, 'login'])
        ->middleware('guest');
});

// Admin Route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin',[AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    
    Route::get('/admin/product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    
    // Product Route
    Route::prefix('admin')->name('admin.')->group(function (){
    Route::get('admin.product.create', [ProductController::class, 'index'])->name('product');
    });

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');

    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])
        ->name('admin.logout')
        ->middleware('admin');
    });

    
// User Route
Route::group(['middleware' => 'web'], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
 
    Route::get('/user-logout', [AuthController::class, 'user_logout'])->name('user.logout')
        ->middleware('web');

    Route::get('/user/product/{id}', [UserController::class, 'detail_product'])->name('user.detail.product');
    Route::get('/product/puschase/{productId}', [UserController::class, 'purchase']);
});