<?php

use App\Http\Controllers\DashboardController as UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\ProductController;
Route::get('/', function () {
    return view('home');
});

Route::group(['prefix'=>'account'],function(){
    //guest
    Route::group(['middleware'=>'guest'],function(){
        Route::get('login',[LoginController::class,'index'])->name('account.login');
        Route::get('register',[LoginController::class,'register'])->name('account.register');
        Route::post('process-register',[LoginController::class,'processRegister'])->name('account.processRegister');
        Route::post('authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
    });
    //authenticated
    Route::group(['middleware'=>'auth'],function(){
        Route::get('logout',[LoginController::class,'logout'])->name('account.logout');
        Route::get('dashboard',[UserController::class,'index'])->name('account.dashboard');
        Route::post('buy/{id}',[UserController::class,'buy'])->name('account.buy');
        Route::get('orders',[UserController::class,'order'])->name('account.orders');
        Route::delete('cancel/{product}',[UserController::class,'cancel'])->name('account.cancel');
    });
});

Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
        Route::get('create',[AdminDashboardController::class,'add'])->name('admin.create');
        Route::put('update/{product}',[ProductController::class,'edit'])->name('admin.update');
        Route::delete('delete/{product}',[ProductController::class,'delete'])->name('admin.delete');
        Route::get('logout',[AdminLoginController::class,'logout'])->name('admin.logout');
        Route::post('Addproduct',[ProductController::class,'create'])->name('admin.Addproduct');
        Route::get('{product}/edit',[AdminDashboardController::class,'update'])->name('admin.edit');

        // Route::get('{product}/delete',[AdminDashboardController::class,'delete'])->name('admin.delete');
    });
});




