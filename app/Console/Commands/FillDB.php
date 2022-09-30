<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Statistic;
use Exception;

class FillDB extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'DB:fill {base_url=https://devtest.ge}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'fill Database with country statistics';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$base_url = $userId = $this->argument('base_url');
		$this->info('Started filling Database');
		$statistics = collect();
		$countries = Http::get($base_url . '/countries')->collect();
		foreach ($countries as $country)
		{
			$countryCode = $country['code'];
			$response = Http::post($base_url . '/get-country-statistics', ['code'=>$countryCode]);
			if ($response->ok())
			{
				$stats = $response->json();
				$countryStat = [
					'id'                => $stats['id'],
					'country'           => json_encode($country['name']),
					'confirmed'         => $stats['confirmed'],
					'recovered'         => $stats['recovered'],
					'deaths'            => $stats['deaths'],
				];
				$statistics->push($countryStat);
			}
			else
			{
				$this->error('An error occurred: a request failed');
				return 1;
			}
		}
		$statistics->prepend([
			'id'       => 1000,
			'country'  => json_encode(['en'=>'Worldwide', 'ka'=>'საერთაშორისო']),
			'confirmed'=> $statistics->sum('confirmed'),
			'recovered'=> $statistics->sum('recovered'),
			'deaths'   => $statistics->sum('deaths'),
		]);
		try
		{
			DB::transaction(function () use ($statistics) {
				Statistic::upsert($statistics->toArray(), ['id'], ['confirmed', 'recovered', 'deaths']);
			});
		}
		catch(Exception $e)
		{
			$this->error('An error occurred: ' . $e->getMessage());
			return 1;
		}
		$this->info('Database filled successfully!');
	}
}
