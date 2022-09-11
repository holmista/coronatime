<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Http\Requests\StoreSigninRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

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
		if (User::find(['email'=>$request->username]) || User::find(['username'=>$request->username]))
		{
			$request->session()->put('requested_verification', true);
			return redirect()->route('verification.notice');
		}
		$attributes = $request->validated();
		if (Auth::attempt($attributes))
		{
			return redirect()->route('home.index')->with('success', 'Welcome back!');
		}
		return redirect()->back()->withInput()->withErrors(['email'=>'invalid credentials']);
	}

	public function signout(): RedirectResponse
	{
		Auth::logout();
		return redirect()->route('auth.view_signin');
	}

	public function verifyEmail(): RedirectResponse
	{
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
}
