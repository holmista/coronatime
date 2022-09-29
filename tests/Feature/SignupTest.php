<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class signupTest extends TestCase
{
	use RefreshDatabase;

	public static $validUsername = 'tornike';

	public static $invalidUsername = 'to';

	public static $validEmail = 'user1@ht.com';

	public static $invalidEmail = 'us';

	public static $validPassword = '123456';

	public static $invalidPassword = '12';

	public static $attributes = [
		'email'          => 'user1@ht.com',
		'username'       => 'tornike',
		'password'       => '123456',
		'repeat_password'=> '123456',
	];

	public function test_should_return_signup_page_if_user_is_not_signed_in()
	{
		$response = $this->get('/signup');
		$response->assertStatus(200);
		$response->assertViewIs('auth.signup');
	}

	public function test_sign_up_page_not_accessible_if_user_is_signed_in()
	{
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/signup');
		$response->assertStatus(302);
		$response->assertRedirect('/');
	}

	public function test_should_give_errors_if_no_input_is_provided()
	{
		$response = $this->post('/signup', []);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['username', 'email', 'password']);
	}

	public function test_should_give_errors_if_invalid_data_is_provided()
	{
		$response = $this->post('/signup', [
			'email'          => $this::$invalidEmail,
			'username'       => $this::$invalidUsername,
			'password'       => $this::$invalidPassword,
			'repeat_password'=> $this::$invalidPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['username', 'email', 'password']);
	}

	public function test_should_give_email_error_if_no_email_is_provided()
	{
		$response = $this->post('/signup', [
			'username'          => $this::$validUsername,
			'password'          => $this::$validPassword,
			'repeat_password'   => $this::$validPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_give_username_error_if_no_username_is_provided()
	{
		$response = $this->post('/signup', [
			'email'          => $this::$validEmail,
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$validPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['username']);
	}

	public function test_should_give_password_error_if_no_password_is_provided()
	{
		$response = $this->post('/signup', [
			'email'          => $this::$validEmail,
			'username'       => $this::$validUsername,
			'repeat_password'=> $this::$validPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['password']);
	}

	public function test_should_give_repeat_password_error_if_passwords_do_not_match()
	{
		$response = $this->post('/signup', [
			'email'          => $this::$validEmail,
			'username'       => $this::$validUsername,
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$invalidPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['repeat_password']);
	}

	public function test_should_give_email_error_if_email_exists_in_database()
	{
		$this->post('/signup', [
			'email'          => $this::$validEmail,
			'username'       => $this::$validUsername,
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$validPassword,
		]);
		$response = $this->post('/signup', [
			'email'          => $this::$validEmail,
			'username'       => 'ajfsdhjf',
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$validPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_give_username_error_if_username_exists_in_database()
	{
		$this->post('/signup', [
			'email'          => $this::$validEmail,
			'username'       => $this::$validUsername,
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$validPassword,
		]);
		$response = $this->post('/signup', [
			'email'          => '1@gmail.com',
			'username'       => $this::$validUsername,
			'password'       => $this::$validPassword,
			'repeat_password'=> $this::$validPassword,
		]);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['username']);
	}

	public function test_should_redirect_to_confirmation_email_sent_if_input_is_valid()
	{
		$response = $this->post('/signup', $this::$attributes);
		$response->assertStatus(302);
		$response->assertSessionHas('requested_verification');
		$response->assertRedirect('/email/verify');
	}

	public function test_send_email_after_user_is_created()
	{
		$user = User::create($this::$attributes);
		Mail::fake();
		Mail::to($user)->send(new VerifyEmail($user));
		Mail::assertSent(VerifyEmail::class, function ($mail) use ($user) {
			return $mail->hasTo($user->email);
		});
	}

	public function test_email_verification_is_not_accessible_when_there_is_no_kv_pair_in_session()
	{
		$response = $this->get('/email/verify');
		$response->assertRedirect(route('auth.view_signup'));
	}
}
