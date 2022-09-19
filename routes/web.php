<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\LocaleController;

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
		Route::post('/signin', 'signin')->name('auth.signin');
	});
	Route::controller(VerifyEmailController::class)->group(function () {
		Route::get('/account-confirmed', 'accountConfirmed')->middleware('requestedVerification')->name('auth.view_account_confirmed');
		Route::get('/email/verify', 'emailSent')->middleware('requestedVerification')->name('verification.notice');
		Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
	});
	Route::controller(ForgotPasswordController::class)->group(function () {
		Route::post('/forgot-password', 'forgotPassword')->name('auth.forgot_password');
		Route::get('/password/verify/{id}/{token}', 'showResetPassword')->name('password.request');
		Route::patch('/reset-password', 'resetPassword')->middleware('requestedReset')->name('password.reset');
		Route::get('/reset-successful', 'resetSuccessful')->middleware('passwordResetSuccessful')->name('auth.reset_success');
	});
	Route::view('/signup', 'auth.signup')->name('auth.view_signup');
	Route::view('/signin', 'auth.signin')->name('auth.view_signin');
	Route::view('/forgot-password', 'auth.forgot-password')->name('password.forgot');
});

Route::middleware(['auth'])->group(function () {
	Route::get('/signout', [AuthController::class, 'signout'])->name('auth.signout');
});
Route::get('/', [StatisticsController::class, 'showWorldwide'])->name('home.index');
Route::get('/countries', [StatisticsController::class, 'index'])->name('country.index');

Route::post('/locale', [LocaleController::class, 'change']);
