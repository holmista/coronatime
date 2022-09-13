<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Http\Requests\StoreSigninRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Mail\VerifyEmail;
use App\Mail\VerifyPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
	public function signup(StoreSignupRequest $request): RedirectResponse
	{
		$attributes = $request->only(['username', 'email', 'password']);
		$attributes['password'] = bcrypt($attributes['password']);
		$user = User::create($attributes);
		Mail::to($user)->queue(new VerifyEmail($user));
		$request->session()->put('requested_verification', true);
		return redirect()->route('verification.notice');
	}

	public function signin(StoreSigninRequest $request): RedirectResponse
	{
		$attributes = $request->validated();
		$user = User::where(['email'=>$attributes['username']])->count() === 0 ? User::where(['username'=>$attributes['username']]) : User::where(['email'=>$attributes['username']]);
		if (!$user->first())
		{
			return redirect()->back()->withInput()->withErrors(['username'=>'invalid email or username']);
		}
		if (!$user->first()->email_verified_at)
		{
			$request->session()->put('requested_verification', true);
			return redirect()->route('verification.notice');
		}
		$remember = array_key_exists('remember', $attributes) ? true : false;
		unset($attributes['remember']);
		if (Auth::attempt(['email'=>$user->first()->email, 'password'=>$attributes['password']], $remember))
		{
			$request->session()->regenerate();
			return redirect()->route('home.index')->with('success', 'Welcome back!');
		}
		return redirect()->back()->withInput()->withErrors(['username'=>'invalid credentials']);
	}

	public function signout(): RedirectResponse
	{
		Auth::logout();
		return redirect()->route('auth.view_signin');
	}

	public function verifyEmail(): RedirectResponse
	{
		if (Carbon::now()->gt(Carbon::createFromTimestamp(request()->query('expires'))))
		{
			dd(Carbon::now(), request()->query('expires'));
			return redirect()->route('auth.view_signup');
		}
		$user = User::findOrFail(request()->id);
		if ($user->hasVerifiedEmail())
		{
			return redirect()->route('auth.view_signin');
		}
		if (!hash_equals(
			(string) request()->hash,
			sha1($user->getEmailForVerification())
		))
		{
			return redirect()->route('auth.view_signup');
		}
		$user->markEmailAsVerified();
		event(new Verified($user));
		request()->session()->put('requested_verification', true);
		return redirect()->route('auth.view_account_confirmed');
	}

	public function accountConfirmed(): View
	{
		if (request()->session()->get('requested_verification'))
		{
			request()->session()->forget('requested_verification');
		}
		return view('auth.account-confirmed');
	}

	public function emailSent(): View
	{
		if (request()->session()->get('requested_verification'))
		{
			request()->session()->forget('requested_verification');
		}
		return view('auth.confirmation-sent');
	}

	public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
	{
		$email = $request->validated()['email'];
		$user = User::where(['email'=>$email])->first();
		if (!$user)
		{
			return redirect()->back()->withInput()->withErrors(['email'=>'invalid email']);
		}
		if (!$user->email_verified_at)
		{
			return redirect()->back()->withInput()->withErrors(['email'=>'email not verified']);
		}
		$token = Str::random(64);
		DB::table('password_resets')->updateOrInsert(['email' => $request->email], [
			'email'      => $request->email,
			'token'      => $token,
			'created_at' => Carbon::now(),
		]);
		Mail::to($user)->queue(new VerifyPassword($token, $user));
		$request->session()->put('requested_verification', true);
		return redirect()->route('verification.notice');
	}

	public function resetPassword(ResetPasswordRequest $request): RedirectResponse
	{
		$attributes = $request->validated();
		$user = User::findOrFail($request->id);
		$token = DB::table('password_resets')->where('email', '=', $user->email)->select('token')->first()->token;
		if ($token != $request->token)
		{
			return redirect()->route('password.forgot');
		}
		User::where(['email'=>$user->email])->update(['password'=>bcrypt($attributes['password'])]);
		DB::table('password_resets')->where('email', $user->email)->delete();
		return redirect()->route('auth.view_signin');
	}

	public function showResetPassword(): View
	{
		if (Carbon::now()->gt(Carbon::createFromTimestamp(request()->query('expires'))))
		{
			return redirect()->route('password.forgot');
		}
		return view('auth.reset-password');
	}
}
