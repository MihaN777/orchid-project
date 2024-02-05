<?php

namespace App\Jobs;

use App\Mail\Admin\RedactorNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RedactorNotificationJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $title;
	protected $link;

	/**
	 * Create a new job instance.
	 */
	public function __construct($title, $link)
	{
		$this->title = $title;
		$this->link = $link;
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		Mail::to(config('mail.redactor_address'))->send(new RedactorNotificationMail($this->title, $this->link));
	}
}
