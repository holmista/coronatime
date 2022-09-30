<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
	use RefreshDatabase;

	public static $attributes = [
		'email'          => 'user1@ht.com',
		'username'       => 'tornike',
		'password'       => '123456',
		'repeat_password'=> '123456',
	];

	public function test_sign_out_redirects_if_user_is_not_signed_in()
	{
		$response = $this->get('/signout');
		$response->assertStatus(302);
		$response->assertRedirect('/signin');
	}

	public function test_sign_out_if_user_is_signed_in()
	{
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/signout');
		$response->assertStatus(302);
		$response->assertRedirect('/signin');
		$response->assertSessionMissing('key');
	}
}
