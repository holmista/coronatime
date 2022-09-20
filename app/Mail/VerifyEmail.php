<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class VerifyEmail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$confirmationUrl = $this->verificationUrl($this->user);
		return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
				->subject('Verify Email Address')
				->view('emails.verify-email')
				->with(['confirmationUrl'=>$confirmationUrl]);
	}

	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $notifiable->getKey(),
				'hash' => sha1($notifiable->getEmailForVerification()),
			]
		);
	}
}
