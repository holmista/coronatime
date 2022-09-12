<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	// protected $redirect = '/signup';

	public function rules()
	{
		// dd(request()->all());
		// request()->merge(['password' => request()->all()['New_password']]);
		// request()->merge(['repeat_password' => request()->all()['Repeat_password']]);
		// dd(request()->all()['password']);
		// request()->merge(['password' => request()->all()['New password']]);
		return [
			'id'                 => ['required', 'exists:users,id'],
			'token'              => ['required', 'exists:password_resets,token'],
			'password'           => ['required', 'min:3'],
			'repeat_password'    => ['same:password'],
		];
	}
}
