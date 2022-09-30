<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
	use RefreshDatabase;

	public function test_locale_changes_to_georgian()
	{
		$response = $this->post('/locale', ['language'=>'ka']);
		$response->assertSessionHas('locale');
		$response = $this->get('/signin');
		$response->assertSee('გამარჯობა');
	}

	public function test_locale_changes_to_english()
	{
		$response = $this->post('/locale', ['language'=>'en']);
		$response->assertSessionHas('locale');
		$response = $this->get('/signin');
		$response->assertSee('Welcome back');
	}
}
