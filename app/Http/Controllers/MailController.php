<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkEmailJob;
use App\Mail\TestMail;
use App\Services\Notification\Mail\SmtpMailFactory;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private SmtpMailFactory $smtpMailFactory;
    public function __construct(SmtpMailFactory $smtpMailFactory) {
        $this->smtpMailFactory = $smtpMailFactory;
    }


    public function __invoke() {
//        $email = "morinq20@gmail.com";
//        $mailService = $this->smtpMailFactory->createMailService();
//        $mailService->setTo($email);
//        $mailService->setSubject('Test Mail Service');
//        $mailService->setData(['name' => 'Hüseyin Balın']);
//        $mailService->setMailable(TestMail::class);
//        $mailService->send();

        $emails = [];
        $email = 'morinq20@gmail.com'; // The email address to repeat

        for ($i = 0; $i < 2; $i++) {
            $emails[] = $email;
        }
        SendBulkEmailJob::dispatch($emails, ['name' => 'Hüseyin Balın']);
        return response()->json('Bulk emails are being sent');
    }
}
