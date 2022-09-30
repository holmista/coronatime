<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
	use HasFactory, HasTranslations;

	public function scopeSort($query, $sorts)
	{
		if ($sorts['country'] ?? false)
		{
			$query->orderBy('country->' . App::currentLocale(), $sorts['country']);
		}
		if ($sorts['confirmed'] ?? false)
		{
			$query->orderBy('confirmed', $sorts['confirmed']);
		}
		if ($sorts['deaths'] ?? false)
		{
			$query->orderBy('deaths', $sorts['deaths']);
		}
		if ($sorts['recovered'] ?? false)
		{
			$query->orderBy('recovered', $sorts['recovered']);
		}
	}

	public $translatable = ['country'];

	protected $guarded = [];

	protected $casts = [
		'country' => 'array',
	];
}
