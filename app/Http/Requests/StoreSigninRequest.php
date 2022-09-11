<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSigninRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'username'  => ['required', 'min:3'],
			'password'  => ['required', 'min:3'],
			'remember'  => ['nullable'],
		];
	}
}
