<?php

namespace App\Services\Notification\Mail;

class SmtpMailFactory implements MailFactory
{
    public function createMailService(): MailService
    {
        return MailService::getInstance();
    }
}
