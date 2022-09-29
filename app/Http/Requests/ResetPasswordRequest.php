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
		return [
			'id'                 => ['required'],
			'token'              => ['required'],
			'password'           => ['required', 'min:3'],
			'repeat_password'    => ['required', 'same:password'],
		];
	}

	public function messages()
	{
		return [
			'repeat_password.same'  => __('texts.passwords_do_not_match'),
		];
	}
}
