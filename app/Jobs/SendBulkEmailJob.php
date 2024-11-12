<?php

namespace App\Jobs;

use App\Mail\TestMail;
use App\Services\Notification\Mail\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBulkEmailJob implements ShouldQueue
{
    use Queueable;

    private array $emails;
    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $emails, array $data)
    {
        $this->emails = $emails;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->emails as $key => $email) {
            $mailService = MailService::getInstance();
            $mailService->setTo($email);
            $mailService->setSubject('Test Mail '.$key);
            $mailService->setData($this->data);
            $mailService->setMailable(TestMail::class);
            $mailService->send();
        }
    }
}
