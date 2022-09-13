<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Mail\VerifyPassword;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
	public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
	{
		$user = User::where(['email'=>$request->email])->first();
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
