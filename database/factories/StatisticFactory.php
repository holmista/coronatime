<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistic>
 */
class StatisticFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'country'   => [
				'en'  => 'Georgia',
				'ka'  => 'საქართველო',
			],
			'confirmed' => fake()->numberBetween(0, 10000),
			'recovered' => fake()->numberBetween(0, 10000),
			'deaths'    => fake()->numberBetween(0, 10000),
		];
	}
}
