<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Http\Requests\StoreSigninRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
		$attributes = $request->validated();
		$user = User::where(['email'=>$request->username])->count() === 0 ? User::where(['username'=>$request->username]) : User::where(['email'=>$request->username]);
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
}
