<?php

use Illuminate\Support\Facades\Route;

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

Route::controller(\App\Http\Controllers\Admin\AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'doLogin')->name('doLogin');
    Route::get('register', 'register')->name('register');
    Route::post('register', 'doRegister')->name('doRegister');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'doLogout'])->name('doLogout');

    Route::get('/', function () {
        return view('welcome');
    });
});


