<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
	use HasFactory, HasTranslations;

	public $translatable = ['country'];

	protected $casts = [
		'country' => 'array',
	];
}
