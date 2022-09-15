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
		return view('stats.landing-country', ['data'=>$data]);
	}

	public function showWorldwide(): View
	{
		$data = Statistic::find(1000);
		return view('stats.landing-worldwide', ['data'=>$data]);
	}
}
