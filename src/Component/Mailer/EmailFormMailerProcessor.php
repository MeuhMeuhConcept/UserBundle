<?php

namespace MMC\User\Component\Mailer;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailFormMailerProcessor implements CodeSender
{
    protected $templating;
    protected $router;

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

    public function sendCode($resourceForm, $code)
    {
        $mail = \Swift_Message::newInstance();

        $url = $this->router->generate(
            'mmc_user.resource_form',
            ['token' => $code],
            routerInterface::ABSOLUTE_URL
        );

        $body = $this->templating->render($this->template, [
            'form' => $resourceForm,
            'code' => $code,
            'url' => $url,

        ]);

        $receiver = $resourceForm->getResource();

        $mail
            ->setFrom($this->sender)
            ->setReplyTo($this->sender)
            ->setTo($receiver)
            ->setSubject($this->subject)
            ->setBody($body)
            ->setContentType('text/html');

        return $this->mailer->send($mail);
    }
}
