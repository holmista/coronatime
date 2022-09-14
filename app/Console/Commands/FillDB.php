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
	protected $signature = 'DB:fill';

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
		$statistics = [];
		$numFailed = 0;
		$countries = Http::get('https://devtest.ge/countries')->collect();
		foreach ($countries as $country)
		{
			if ($numFailed > 2)
			{
				$this->error('An error occurred: too many requests failed');
				return false;
			}
			$countryCode = $country['code'];
			$response = Http::post('https://devtest.ge/get-country-statistics', ['code'=>$countryCode]);
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
				array_push($statistics, $countryStat);
			}
			else
			{
				$numFailed += 1;
			}
		}
		try
		{
			DB::transaction(function () use ($statistics) {
				Statistic::upsert($statistics, ['id'], ['confirmed', 'recovered', 'deaths']);
			});
		}
		catch(Exception $e)
		{
			$this->error('An error occurred: ' . $e->getMessage());
			return false;
		}
		$this->info('Database filled successfully!');
	}
}
