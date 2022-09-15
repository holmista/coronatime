<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\View\View;

class StatisticsController extends Controller
{
	public function index(): View
	{
		$data = Statistic::latest()->get();
		$worldwide = $data->pop();
		$data->prepend($worldwide);
		// ddd($data);
		return view('stats.landing-country', ['data'=>$data]);
	}
}
