<?php

namespace App\Services\Notification\Mail;

interface MailFactory
{
    public function createMailService(): MailService;
}
