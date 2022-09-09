<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Http\Requests\StoreSigninRequest;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function signup(StoreSignupRequest $request): RedirectResponse
	{
		$attributes = $request->only(['username', 'email', 'password']);
		$attributes['password'] = bcrypt($attributes['password']);
		$user = User::create($attributes);
		event(new Registered($user));
		$request->session()->put('requested_verification', true);
		return redirect()->route('verification.notice');
	}

	public function signin(StoreSigninRequest $request): RedirectResponse
	{
		$attributes = $request->validated();
		if (Auth::attempt($attributes))
		{
			return redirect()->intended()->with('success', 'Welcome back!');
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
		if (request()->session->get('requested_verification'))
		{
			request()->session->forget('requested_verification');
		}
		return redirect()->route('auth.view_account_confirmed');
	}
}
