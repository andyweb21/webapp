<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;

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

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'check_login'])->name('login.check_login');
});

Route::middleware([Authenticate::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/user', [UserController::class, 'index'])->name('user');

    Route::get('/user/read',[UserController::class,'read']);
    Route::get('/user/list',[UserController::class,'list'])->name('user.list');
    Route::get('/user/create',[UserController::class,'create']);
    Route::post('/user/store',[UserController::class,'store']);
    Route::get('/user/show/{id}',[UserController::class,'show']);
    Route::post('/user/update/{id}',[UserController::class,'update']);
    Route::get('/user/destroy/{id}',[UserController::class,'destroy']);

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
