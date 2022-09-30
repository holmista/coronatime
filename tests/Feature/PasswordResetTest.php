<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\VerifyPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PasswordResetTest extends TestCase
{
	use RefreshDatabase;

	private function render($mailable)
	{
		$mailable->build();
		return view($mailable->view, $mailable->buildViewData())->render();
	}

	private static function generateResetUrl()
	{
		$user = User::create(self::$attributes);
		$token = Str::random(64);
		$url = URL::temporarySignedRoute(
			'password.request',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'      => $user->id,
				'token'   => $token,
			]
		);
		return $url;
	}

	public static $attributes = [
		'email'          => 'user1@ht.com',
		'username'       => 'tornike',
		'password'       => '123456',
		'repeat_password'=> '123456',
	];

	public function test_password_forgot_page_should_redirect_to_home_page_if_user_is_signed_in()
	{
		$user = User::create($this::$attributes);
		$this->actingAs($user);
		$response = $this->get('/forgot-password');
		$response->assertStatus(302);
		$response->assertRedirect('/');
	}

	public function test_password_forgot_page_should_show_if_user_is_not_signed_in()
	{
		$response = $this->get('/forgot-password');
		$response->assertStatus(200);
	}

	public function test_should_give_email_error_if_email_is_not_provided()
	{
		$response = $this->post('/forgot-password');
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_give_email_error_if_email_does_not_exist()
	{
		$response = $this->post('/forgot-password', ['email'=>'1@gmail.com']);
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_give_email_error_if_email_is_in_incorrect_format()
	{
		$response = $this->post('/forgot-password', ['email'=>'1gmail.com']);
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_give_email_error_if_email_is_valid_but_not_verified()
	{
		$user = User::create($this::$attributes);
		$response = $this->post('/forgot-password', ['email'=>$this::$attributes['email']]);
		$response->assertSessionHasErrors(['email']);
	}

	public function test_should_redirect_to_email_sent_page_if_email_is_valid_and_verified()
	{
		$user = User::create(array_merge($this::$attributes, ['email_verified_at'=>date('Y-m-d H:i:s')]));
		$response = $this->post('/forgot-password', ['email'=>$this::$attributes['email']]);
		$response->assertSessionHas('requested_reset');
		$response->assertRedirect(route('password.reset_sent'));
	}

	public function test_reset_sent_page_should_show_if_user_requested_password_reset()
	{
		$response = $this->withSession(['requested_reset'=>true])->get('/reset-sent');
		$response->assertStatus(200);
	}

	public function test_reset_sent_page_should_redirect_if_user_has_not_requested_password_reset()
	{
		$response = $this->get('/reset-sent');
		$response->assertStatus(302);
		$response->assertRedirect(route('password.forgot'));
	}

	public function test_should_send_email_after_password_reset_is_requested()
	{
		$user = User::create($this::$attributes);
		$token = Str::random(64);
		$email = new VerifyPassword($token, $user);
		$rendered = $email->render();
		$url = URL::temporarySignedRoute(
			'password.request',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'      => $user->id,
				'token'   => $token,
			]
		);
		$this->assertStringContainsString($url, htmlspecialchars_decode($rendered));
		Mail::fake();
		Mail::to($user)->send($email);
		Mail::assertSent(VerifyPassword::class, function ($mail) use ($user) {
			return $mail->hasTo($user->email);
		});
	}

	public function test_should_show_reset_password_page_when_reset_url_is_accessed()
	{
		$url = $this::generateResetUrl();
		$response = $this->get($url);
		$response->assertViewIs('auth.reset-password');
	}

	public function test_should_redirect_to_forgot_password_page_if_reset_link_is_expired()
	{
		$user = User::create($this::$attributes);
		$token = Str::random(64);
		$url = URL::temporarySignedRoute(
			'password.request',
			Carbon::now()->addSeconds(Config::get('auth.verification.expire', 1)),
			[
				'id'      => $user->id,
				'token'   => $token,
			]
		);
		sleep(2);
		$response = $this->get($url);
		$response->assertRedirect(route('password.forgot'));
	}

	public function test_should_give_errors_if_no_input_is_provided_in_reset_password_page()
	{
		$url = $this::generateResetUrl();
		$response = $this->get($url);
		$response->assertOk();
		$response = $this->patch('/reset-password');
		$response->assertSessionHasErrors(['id', 'token', 'password']);
	}

	public function test_should_give_404_error_if_id_is_invalid_in_reset_password_page()
	{
		$url = $this::generateResetUrl();
		$exploded = explode('/', $url);
		$exploded[5] = 10;
		$response = $this->patch('/reset-password', ['id'=>$exploded[5], 'token'=>$exploded[6], 'password'=>'123456', 'repeat_password'=>'123456']);
		$response->assertStatus(404);
	}

	public function test_should_redirect_to_password_forgot_page_if_token_is_not_in_database()
	{
		// $user = User::create($this::$attributes);
		$url = $this::generateResetUrl();
		$exploded = explode('/', $url);
		$response = $this->patch('/reset-password', ['id'=>$exploded[5], 'token'=>'hghvhkhgj', 'password'=>'123456', 'repeat_password'=>'123456']);
		$response->assertStatus(302);
		$response->assertRedirect(route('password.forgot'));
	}

	public function test_should_redirect_to_password_forgot_page_if_token_is_invalid_in_reset_password_page()
	{
		$url = $this::generateResetUrl();
		$exploded = explode('/', $url);
		DB::table('password_resets')->updateOrInsert(['email' => $this::$attributes['email']], [
			'email'      => $this::$attributes['email'],
			'token'      => $exploded[6],
			'created_at' => Carbon::now(),
		]);
		$response = $this->patch('/reset-password', ['id'=>$exploded[5], 'token'=>'hghvhkhgj', 'password'=>'123456', 'repeat_password'=>'123456']);
		$response->assertStatus(302);
		$response->assertRedirect(route('password.forgot'));
	}

	public function test_should_give_error_on_password_reset_page_if_passwords_do_not_match()
	{
		$url = $this::generateResetUrl();
		$exploded = explode('/', $url);
		DB::table('password_resets')->updateOrInsert(['email' => $this::$attributes['email']], [
			'email'      => $this::$attributes['email'],
			'token'      => $exploded[6],
			'created_at' => Carbon::now(),
		]);
		$response = $this->patch('/reset-password', ['id'=>$exploded[5], 'token'=>$exploded[6], 'password'=>'123456', 'repeat_password'=>'12345']);
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['repeat_password']);
	}

	public function test_should_change_password_if_id_and_token_are_valid_and_passwords_match()
	{
		$url = $this::generateResetUrl();
		$exploded = explode('/', $url);
		DB::table('password_resets')->updateOrInsert(['email' => $this::$attributes['email']], [
			'email'      => $this::$attributes['email'],
			'token'      => $exploded[6],
			'created_at' => Carbon::now(),
		]);
		$response = $this->withSession(['requested_reset'=>true])->patch('/reset-password', ['id'=>$exploded[5], 'token'=>$exploded[6], 'password'=>'123456', 'repeat_password'=>'123456']);
		$response->assertStatus(302);
		$response->assertSessionHas('password_reset_successful');
		$response->assertRedirect(route('auth.reset_success'));
		$response->assertSessionMissing('requested_reset');
		$count = DB::table('password_resets')->count();
		$this->assertTrue($count === 0);
	}

	public function test_reset_successful_page_is_accessible_only_when_password_gets_changed()
	{
		$response = $this->withSession(['password_reset_successful'=>true])->get('/reset-successful');
		$response->assertStatus(200);
		$response->assertSessionMissing('password_reset_successful');
	}

	public function test_reset_successful_page_redirects_if_user_has_not_changed_password()
	{
		$response = $this->get('/reset-successful');
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_signup'));
	}
}
