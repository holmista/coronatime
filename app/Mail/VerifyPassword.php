<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class VerifyPassword extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	private $token;

	private $user;

	public function __construct($token, $user)
	{
		$this->token = $token;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$resetUrl = $this->generateUrl($this->user);
		return $this->from('example@example.com', 'Example')
				->subject('Reset Password')
				->view('emails.recover-password')
				->with(['resetUrl'=>$resetUrl]);
	}

	protected function generateUrl($notifiable)
	{
		return URL::temporarySignedRoute(
			'password.request',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'      => $this->user->id,
				'token'   => $this->token,
			]
		);
	}
}
