<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\View\View;

class StatisticsController extends Controller
{
	public function index(): View
	{
		$query = Statistic::latest();
		$search = ucfirst(strtolower(request('search')));
		if (request('search'))
		{
			$query->where('country->en', 'like', '%' . $search . '%')
			->orWhere('country->ka', 'like', '%' . $search . '%');
		}
		$data = $query->sort(request()->only('country', 'confirmed', 'deaths', 'recovered'))->get();
		if (request()->query->count() === 0)
		{
			$worldwide = Statistic::find(1000);
			$data->prepend($worldwide);
		}
		return view('stats.landing-country', ['data'=>$data]);
	}

	public function showWorldwide(): View
	{
		$data = Statistic::find(1000);
		return view('stats.landing-worldwide', ['data'=>$data]);
	}
}
