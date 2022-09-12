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
	Route::get('/account-confirmed', [AuthController::class, 'accountConfirmed'])->middleware('requestedVerification')->name('auth.view_account_confirmed');
	Route::get('/email/verify', [AuthController::class, 'emailSent'])->middleware('requestedVerification')->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
	Route::post('/signin', [AuthController::class, 'signin']);
	Route::view('/forgot-password', 'auth.forgot-password')->name('password.forgot');
	Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
	Route::get('/password/verify/{id}/{token}', [AuthController::class, 'showResetPassword'])->name('password.request');
	Route::patch('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
	Route::view('/', 'home')->name('home.index');
	Route::get('/signout', [AuthController::class, 'signout']);
});
