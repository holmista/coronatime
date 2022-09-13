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
	Route::controller(AuthController::class)->group(function () {
		Route::post('/signup', 'signup')->name('auth.signup')->name('auth.signup');
		Route::get('/account-confirmed', 'accountConfirmed')->middleware('requestedVerification')->name('auth.view_account_confirmed');
		Route::get('/email/verify', 'emailSent')->middleware('requestedVerification')->name('verification.notice');
		Route::post('/signin', 'signin')->name('auth.signin');
		Route::post('/forgot-password', 'forgotPassword')->name('auth.forgot_password');
		Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
		Route::get('/password/verify/{id}/{token}', 'showResetPassword')->name('password.request');
		Route::patch('/reset-password', 'resetPassword')->name('password.reset');
	});
	Route::view('/signup', 'auth.signup')->name('auth.view_signup');
	Route::view('/signin', 'auth.signin')->name('auth.view_signin');
	Route::view('/forgot-password', 'auth.forgot-password')->name('password.forgot');
});

Route::middleware(['auth'])->group(function () {
	Route::view('/', 'home')->name('home.index');
	Route::get('/signout', [AuthController::class, 'signout'])->name('auth.signout');
});
