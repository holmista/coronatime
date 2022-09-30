<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class SigninTest extends TestCase
{
	use RefreshDatabase;

	public function test_should_return_200_status_code_on_signin_page_if_user_is_not_logged_in()
	{
		$response = $this->get('/signin');
		$response->assertStatus(200);
		$response->assertViewIs('auth.signin');
	}

	public function test_should_return_302_status_code_on_signin_page_if_user_is_logged_in()
	{
		$username = 'tornike';
		$email = 'user1@ht.com';
		$password = bcrypt('123456');
		$email_verified_at = date('Y-m-d H:i:s');
		User::create(
			[
				'username'         => $username,
				'email'            => $email,
				'password'         => $password,
				'email_verified_at'=> $email_verified_at,
			]
		);
		$response = $this->post('/signin', [
			'username'   => $email,
			'password'   => '123456',
		]);
		$response->assertRedirect('/');
		$response = $this->get('/signin');
		$response->assertRedirect('/');
	}

	public function test_sign_in_should_give_username_and_password_errors_if_no_input_is_provided()
	{
		$response = $this->post('/signin');
		$response->assertSessionHasErrors(['username', 'password']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_error_if_username_is_not_provided_and_password_length_is_more_than_3()
	{
		$response = $this->post('/signin', ['password'=>'123456']);
		$response->assertSessionHasErrors(['username']);
		$response->assertSessionDoesntHaveErrors('password');
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_password_error_if_password_is_not_provided_and_username_length_is_more_than_3()
	{
		$response = $this->post('/signin', ['username'=>'user1']);
		$response->assertSessionHasErrors(['password']);
		$response->assertSessionDoesntHaveErrors(['username']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_and_password_errors_if_username_length_is_less_than_3_and_password_is_not_provided()
	{
		$response = $this->post('/signin', ['username'=>'us']);
		$response->assertSessionHasErrors(['username', 'password']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_and_password_errors_if_username_is_not_provided_and_password_length_is_less_than_3()
	{
		$response = $this->post('/signin', ['password'=>'12']);
		$response->assertSessionHasErrors(['username', 'password']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_error_if_username_length_is_less_than_3_and_password_length_is_more_than_3()
	{
		$response = $this->post('/signin', ['username'=>'us', 'password'=>'123456']);
		$response->assertSessionHasErrors(['username']);
		$response->assertSessionDoesntHaveErrors(['password']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_and_password_errors_if_username_length_is_less_than_3_and_password_length_is_less_than_3()
	{
		$response = $this->post('/signin', ['username'=>'us', 'password'=>'12']);
		$response->assertSessionHasErrors(['username', 'password']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_password_error_if_username_length_is_more_than_3_and_password_length_is_less_than_3()
	{
		$response = $this->post('/signin', ['username'=>'user1', 'password'=>'12']);
		$response->assertSessionHasErrors(['password']);
		$response->assertSessionDoesntHaveErrors(['username']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_give_username_error_if_email_or_username_is_not_found_in_the_database()
	{
		$response = $this->post('/signin', ['username'=>'user1@ht.com', 'password'=>'123456']);
		$response->assertSessionHasErrors(['username']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_redirect_to_auth_confirmation_sent_view_if_email_is_not_verified()
	{
		$username = 'tornike';
		$email = 'user1@ht.com';
		$password = bcrypt('123456');
		User::create(
			[
				'username'=> $username,
				'email'   => $email,
				'password'=> $password,
			]
		);
		$response = $this->post('/signin', [
			'username'   => $email,
			'password'   => '123456',
		]);
		$response->assertSessionHas('requested_verification');
		$response->assertRedirect('/email/verify');
	}

	public function test_sign_in_should_give_password_error_if_email_or_username_is_found_in_the_database_but_passwords_do_not_match_and_email_is_verified()
	{
		$username = 'tornike';
		$email = 'user1@ht.com';
		$password = bcrypt('123456');
		$email_verified_at = date('Y-m-d H:i:s');
		User::create(
			[
				'username'         => $username,
				'email'            => $email,
				'password'         => $password,
				'email_verified_at'=> $email_verified_at,
			]
		);
		$response = $this->post('/signin', [
			'username'   => $email,
			'password'   => '12345',
		]);
		$response->assertSessionHasErrors(['username']);
		$response->assertStatus(302);
	}

	public function test_sign_in_should_redirect_to_stats_landing_worldwide_view_if_credentials_are_valid_and_email_is_verified()
	{
		$username = 'tornike';
		$email = 'user1@ht.com';
		$password = bcrypt('123456');
		$email_verified_at = date('Y-m-d H:i:s');
		User::create(
			[
				'username'         => $username,
				'email'            => $email,
				'password'         => $password,
				'email_verified_at'=> $email_verified_at,
			]
		);
		$response = $this->post('/signin', [
			'username'   => $email,
			'password'   => '123456',
		]);
		$response->assertRedirect('/');
	}
}
