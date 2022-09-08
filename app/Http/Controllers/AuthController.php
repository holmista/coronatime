<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignupRequest;
use App\Models\User;

class AuthController extends Controller
{
	public function signup(StoreSignupRequest $request)
	{
		$user = $request->only(['username', 'email', 'password']);
		$user['password'] = bcrypt($user['password']);
		// dd($user);
		User::create($user);
	}
}
