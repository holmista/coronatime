<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
	public function change()
	{
		$locale = request()->only('language');
		// dd($locale['language']);
		session()->put('locale', $locale['language']);
		return redirect()->back();
	}
}
