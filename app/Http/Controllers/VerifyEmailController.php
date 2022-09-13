<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
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
}
