<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class FillDBTest extends TestCase
{
	use RefreshDatabase;

	public function test_db_fill_command_fails_if_response_status_is_not_200()
	{
		Http::fake([
			'fake.com/countries'                      => Http::response([['code'=>'AF', 'name'=>['en'=>'Afghanistan', 'ka'=> 'ავღანეთი']]]),
			'fake.com/get-country-statistics'         => Http::response('no response', 404),
		]);
		$this->artisan('DB:fill', ['base_url'=>'fake.com'])->assertFailed();
	}

	public function test_db_fill_command_fails_error_occurs_during_upserting_data()
	{
		Http::fake([
			'fake.com/countries'                      => Http::response([['code'=>'AF', 'name'=>['en'=>'Afghanistan', 'ka'=> 'ავღანეთი']]]),
			'fake.com/get-country-statistics'         => Http::response([
				'id'        => 29,
				'country'   => 'Georgia',
				'code'      => 'GE',
				'confirmed' => 2398,
				'recovered' => 3147777777777777777777777777777777777777777777777777777,
				'critical'  => 2349,
				'deaths'    => 477,
				'created_at'=> '2021-09-13T11:43:39.000000Z',
				'updated_at'=> '2021-09-13T11:43:39.000000Z',
			], 200),
		]);
		$this->artisan('DB:fill', ['base_url'=>'fake.com'])->assertFailed();
	}

	public function test_db_fill_command_fills_successfully()
	{
		Http::fake([
			'fake.com/countries'                      => Http::response([['code'=>'AF', 'name'=>['en'=>'Afghanistan', 'ka'=> 'ავღანეთი']]]),
			'fake.com/get-country-statistics'         => Http::response([
				'id'        => 29,
				'country'   => 'Georgia',
				'code'      => 'GE',
				'confirmed' => 2398,
				'recovered' => 3147,
				'critical'  => 2349,
				'deaths'    => 477,
				'created_at'=> '2021-09-13T11:43:39.000000Z',
				'updated_at'=> '2021-09-13T11:43:39.000000Z',
			], 200),
		]);
		$this->artisan('DB:fill', ['base_url'=>'fake.com'])->assertSuccessful();
	}
}
