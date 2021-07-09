<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',[ProductController::class,'index']);

Route::get('master', function () {
    return view('Admin.master');
});

Route::get('index', [ProductController::class,'index'])->name('index');

//Đặt hàng
Route::get('checkout', [ProductController::class,'checkout'])->name('checkout');
Route::post('checkout', [ProductController::class,'postCheckout'])->name('postCheckout');

Route::get('about', function(){
    return view('Others.about');
})->name('about');

Route::get('test', function(){
    return view('welcome');
});

Route::get('contact', function(){
    return view('Others.contact');
})->name('contact');

Route::get('login', [UserController::class,'getLogin'])->name('login');
Route::post('login', [UserController::class,'postLogin'])->name('login');
Route::get('logout', [UserController::class,'logout'])->name('logout');

Route::get('sign-up', [UserController::class,'getSignup'])->name('sign-up');
Route::post('sign-up', [UserController::class,'postSignup'])->name('postSignup');

Route::get('detail/{id}', [ProductController::class,'show'])->name('detail-product');
Route::get('type/{id}', [ProductController::class,'typeProduct'])->name('type-product');

//Cart
//để liên kết với nút hình Giỏ hàng để thêm sản phẩm vào giỏ hàng
Route::get('/add-to-cart/{id}',[ProductController::class,'addToCart'])->name('addtocart');
Route::get('/add-many-to-cart/{id}',[ProductController::class,'addManyToCart'])->name('addmanytocart');
Route::get('/delete-cart/{id}',[ProductController::class,'delCart'])->name('delete-cart');

Route::get('admin/login',[AdminController::class,'getLogin'])->name('admin.login');

Route::prefix('admin')->middleware(['middleware' => 'adminLogin'])->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('add',[AdminController::class,'getAddProduct'])->name('product.add');
        Route::get('edit',[AdminController::class,'getEditProduct'])->name('product.edit');
        Route::get('list',[AdminController::class,'getListProduct'])->name('product.list'); 
    });
    // Route::middleware(['auth', 'second'])->group(function () {
        
    // });
    // Route::prefix('category')->group(function () {
    //     Route::get('add',[AdminController::class,'getAddProduct'])->name('product.add');
    //     Route::get('edit',[AdminController::class,'getEditProduct'])->name('product.edit');
    //     Route::get('list',[AdminController::class,'getListProduct'])->name('product.list'); 
    // });
    // Route::prefix('user')->group(function () {
    //     Route::get('add',[AdminController::class,'getAddProduct'])->name('product.add');
    //     Route::get('edit',[AdminController::class,'getEditProduct'])->name('product.edit');
    //     Route::get('list',[AdminController::class,'getListProduct'])->name('product.list'); 
    // });
 
});

