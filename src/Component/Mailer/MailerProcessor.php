<?php

namespace MMC\User\Component\Mailer;

class MailerProcessor
{
    protected $mailer;
    protected $sender;
    protected $receiver;
    protected $body;
    protected $subject;

    public function sendMessage()
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->sender)
            ->setReplyTo($this->sender)
            ->setTo($this->receiver)
            ->setSubject($this->subject)
            ->setBody($this->body)
            ->setContentType('text/html');

        return $this->mailer->send($mail);
    }
}
