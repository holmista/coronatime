<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware(['guest'])->group(function () {
	Route::view('/signup', 'auth.signup')->name('auth.view_signup');
	Route::post('/signup', [AuthController::class, 'signup'])->name('auth.signup');
	Route::view('/signin', 'auth.signin')->name('auth.view_signin');
	Route::view('/account-confirmed', 'auth.account-confirmed')->name('auth.view_account_confirmed');
	Route::view('/email/verify', 'auth.confirmation-sent')->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
	Route::post('/signin', [AuthController::class, 'signin']);
});

Route::middleware(['auth'])->group(function () {
	Route::view('/', 'home')->name('home.index');
});
