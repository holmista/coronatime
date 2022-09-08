<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
	public function signup(StoreSignupRequest $request): RedirectResponse
	{
		$user = $request->only(['username', 'email', 'password']);
		$user['password'] = bcrypt($user['password']);
		User::create($user);
		return redirect()->route('verification.notice');
	}

	public function confirmationSent(): View
	{
		return view('auth.confirmation-sent');
	}
}
