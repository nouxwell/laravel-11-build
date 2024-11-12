<?php

namespace App\Services\Notification\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private static ?MailService $instance = null;

    private Mailable $mailable;
    private string $to;
    private string $subject;
    private ?string $replyTo = null;
    private ?array $cc = null;
    private ?array $bcc = null;
    private ?array $data = [];
    private ?array $attachments = [];

    private function __construct() {}

    /**
     * Get the single instance of MailService
     *
     * @return MailService
     */
    public static function getInstance(): MailService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return Mailable
     */
    public function getMailable(): Mailable
    {
        return $this->mailable;
    }

    /**
     * @param string $mailableClass
     */
    public function setMailable(string $mailableClass): void
    {
        $mailable = App::make($mailableClass);
        $this->mailable = $mailable->withData($this->getData(), $this->getAttachments());
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return array|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * @param array|null $attachments
     */
    public function setAttachments(?array $attachments): void
    {
        $this->attachments = $attachments;
    }

    /**
     * @return string|null
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * @param string|null $replyTo
     */
    public function setReplyTo(?string $replyTo): void
    {
        $this->replyTo = $replyTo;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getCc(): ?array
    {
        return $this->cc;
    }

    /**
     * @param array|null $cc
     */
    public function setCc(?array $cc): void
    {
        $this->cc = $cc;
    }

    /**
     * @return array|null
     */
    public function getBcc(): ?array
    {
        return $this->bcc;
    }

    /**
     * @param array|null $bcc
     */
    public function setBcc(?array $bcc): void
    {
        $this->bcc = $bcc;
    }

    public function send(): void
    {
        $mail = Mail::to($this->getTo());
        if ($this->getCc())
            $mail->cc($this->getCc());

        if ($this->getBcc())
            $mail->bcc($this->getBcc());

        if ($this->getReplyTo())
            $mail->replyTo($this->getReplyTo());

        $mail->send($this->getMailable());
    }

}
