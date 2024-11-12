<?php

namespace App\Hexagon\Application\Jobs;

use App\Hexagon\Application\Mail\VerificationMail;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Notification\Mail\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerificationJob implements ShouldQueue
{
    use Queueable;

    private string $id;
    private string $email;
    private string $fullName;

    /**
     * Create a new job instance.
     */
    public function __construct(string $id, string $email, string $fullName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->fullName = $fullName;
    }


    public function handle(): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $this->id]
        );
        $mailService = MailService::getInstance();
        $mailService->setTo($this->email);
        $mailService->setSubject(__(PayloadMessage::EMAIL_VERIFICATION));
        $mailService->setData(['verificationUrl' => $verificationUrl, 'fullName' => $this->fullName]);
        $mailService->setMailable(VerificationMail::class);
        $mailService->send();
    }
}
