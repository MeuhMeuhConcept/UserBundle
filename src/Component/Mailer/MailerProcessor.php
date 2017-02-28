<?php

namespace MMC\User\Component\Mailer;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Ramsey\Uuid\Uuid;

class MailerProcessor
{
    protected $mailer;
    protected $templating;
    protected $router;
    protected $receiver;
    protected $sender;
    protected $template;
    protected $subject;

    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $templating,
        RouterInterface $router,
        $sender,
        $template,
        $subject
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->sender = $sender;
        $this->template = $template;
        $this->subject = $subject;
    }
    public function process($form)
    {
        $mail = \Swift_Message::newInstance();

        $url = $this->router->generate(
            'mmc_user.registration_confirmation',
            ['token' => 'ExempleToken'],
            //['token' => $user->getConfirmationToken()],
            routerInterface::ABSOLUTE_URL
        );

        $body = $this->templating->render($this->template, [
            'form' => $form,
            'url' => $url
        ]);

        dump(uniqid(), $url, $form, $body);die;

        $mail
            ->setFrom($this->sender)
            ->setReplyTo($this->sender)
            ->setTo($form->getEmail())
            ->setSubject($this->subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
