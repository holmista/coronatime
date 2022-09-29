<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Statistic;

class StatisticsTest extends TestCase
{
	use RefreshDatabase;

	public static function fillDB()
	{
		Statistic::factory()->create(
			['country'   => [
				'en'  => 'Georgia',
				'ka'  => 'საქართველო',
			],
				'confirmed'=> 1000,
				'deaths'   => 500,
				'recovered'=> 2000,
			]
		);
		Statistic::factory()->create(
			['country'   => [
				'en'  => 'France',
				'ka'  => 'საფრანგეთი',
			],
				'confirmed'=> 1001,
				'deaths'   => 5000,
				'recovered'=> 1000,
			]
		);
		Statistic::factory()->create(
			['country'   => [
				'en'  => 'Canada',
				'ka'  => 'კანადა',
			],
				'confirmed'=> 1002,
				'deaths'   => 3000,
				'recovered'=> 3000,
			]
		);
		Statistic::factory()->create(
			['country'   => [
				'en'  => 'Worldwide',
				'ka'  => 'საერთაშორისო',
			],
				'confirmed'=> 1003,
				'deaths'   => 100000,
				'recovered'=> 20000,
				'id'       => 1000,
			]
		);
	}

	public static $attributes = [
		'email'          => 'user1@ht.com',
		'username'       => 'tornike',
		'password'       => '123456',
		'repeat_password'=> '123456',
	];

	public function test_home_page_redirects_if_user_is_not_signed_in()
	{
		$response = $this->get('/');
		$response->assertStatus(302);
		$response->assertRedirect('/signin');
	}

	public function test_home_page_is_accessible_if_user_is_signed_in()
	{
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$data = Statistic::factory()->create(['id'=>1000]);
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertViewIs('stats.landing-worldwide');
		$response->assertSee($user->username);
	}

	public function test_countries_page_redirects_if_user_is_not_signed_in()
	{
		$response = $this->get('/countries');
		$response->assertStatus(302);
		$response->assertRedirect('/signin');
	}

	public function test_countries_page_is_accessible_if_user_is_signed_in()
	{
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		Statistic::factory(5)->create();
		Statistic::factory()->create(['id'=>1000]);
		$response = $this->get('/countries');
		$response->assertStatus(200);
		$response->assertViewIs('stats.landing-country');
		$response->assertSee($user->username);
	}

	public function test_countries_page_sort_by_country_ascending()
	{
		$this::fillDB();
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/countries?country=asc');
		$response->assertStatus(200);
		$response->assertSeeInOrder(['Canada', 'France', 'Georgia', 'Worldwide']);
	}

	public function test_countries_page_sort_by_confirmed_ascending()
	{
		$this::fillDB();
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/countries?confirmed=asc');
		$response->assertStatus(200);
		$response->assertSeeInOrder(['Georgia', 'France', 'Canada', 'Worldwide']);
	}

	public function test_countries_page_sort_by_deaths_ascending()
	{
		$this::fillDB();
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/countries?deaths=asc');
		$response->assertStatus(200);
		$response->assertSeeInOrder(['Georgia', 'Canada', 'France', 'Worldwide']);
	}

	public function test_countries_page_sort_by_recovered_ascending()
	{
		$this::fillDB();
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/countries?recovered=asc');
		$response->assertStatus(200);
		$response->assertSeeInOrder(['France', 'Georgia', 'Canada', 'Worldwide']);
	}

	public function test_countries_page_filter_should_return_filtered_countries()
	{
		$this::fillDB();
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/countries?search=e');
		$response->assertSee('Georgia');
		$response->assertSee('Worldwide');
		$response->assertSee('France');
	}
}
