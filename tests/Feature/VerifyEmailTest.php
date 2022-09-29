<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class VerifyEmailTest extends TestCase
{
	use RefreshDatabase;

	private function render($mailable)
	{
		$mailable->build();
		return view($mailable->view, $mailable->buildViewData())->render();
	}

	private static function generateVerificationUrl()
	{
		$user = User::create(self::$attributes);
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $user->getKey(),
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		return [$url, $user];
	}

	public static $attributes = [
		'email'          => 'user1@ht.com',
		'username'       => 'tornike',
		'password'       => '123456',
		'repeat_password'=> '123456',
	];

	public function test_email_verification_page_accessible_after_user_signed_up()
	{
		$response = $this->withSession(['requested_verification'=>true])->get('/email/verify');
		$response->assertStatus(200);
		$response->assertViewIs('auth.confirmation-sent');
	}

	public function test_email_verification_page_redirects_if_user_did_not_sign_up()
	{
		$response = $this->get('/email/verify');
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_signup'));
	}

	public function test_should_send_email_after_verification_is_requested()
	{
		$user = User::create($this::$attributes);
		$email = new VerifyEmail($user);
		$rendered = $email->render();
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $user->getKey(),
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		$this->assertStringContainsString($url, htmlspecialchars_decode($rendered));
		Mail::fake();
		Mail::to($user)->send($email);
		Mail::assertSent(VerifyEmail::class, function ($mail) use ($user) {
			return $mail->hasTo($user->email);
		});
	}

	public function test_should_verify_email_after_verification_link_is_clicked()
	{
		[$url, $user] = $this::generateVerificationUrl();
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_account_confirmed'));
	}

	public function test_should_redirect_if_verification_link_is_expired()
	{
		$user = User::create(self::$attributes);
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addSeconds(Config::get('auth.verification.expire', 1)),
			[
				'id'   => $user->getKey(),
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		sleep(2);
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_signup'));
	}

	public function test_should_give_404_error_if_user_does_not_exist()
	{
		$user = User::create(self::$attributes);
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => 7,
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(404);
	}

	public function test_should_redirect_to_signin_page_if_user_email_is_verified_when_verification_link_is_clicked()
	{
		$user = User::create(array_merge(self::$attributes, ['email_verified_at'=>Carbon::now()]));
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $user->getKey(),
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_signin'));
	}

	public function test_should_redirect_to_signup_page_if_hash_is_different()
	{
		$user = User::create(self::$attributes);
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $user->getKey(),
				'hash' => 'abcd',
			]
		);
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_signup'));
	}

	public function test_should_redirect_to_email_verified_page_if_verification_link_is_valid()
	{
		$user = User::create(self::$attributes);
		$url = URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $user->getKey(),
				'hash' => sha1($user->getEmailForVerification()),
			]
		);
		$response = $this->get(str_replace('http://localhost', '', $url));
		$response->assertStatus(302);
		$response->assertRedirect(route('auth.view_account_confirmed'));
		$response->assertSessionHas('requested_verification');
	}

	public function test_email_verified_page_is_available_if_user_did_not_confirm_email()
	{
		$response = $this->withSession(['requested_verification'=>true])->get('/account-confirmed');
		$response->assertOk();
		$response->assertViewIs('auth.account-confirmed');
		$response->assertSessionMissing('requested_verification');
	}
}
