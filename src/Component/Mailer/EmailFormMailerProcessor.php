<?php

namespace MMC\User\Component\Mailer;

use MMC\User\Bundle\EmailBundle\Entity\EmailFormAuthentication;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailFormMailerProcessor extends MailerProcessor
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

    public function sendEmailWithCode(EmailFormAuthentication $emailForm, $code)
    {
        $this->body = $this->templating->render($this->template, [
            'form' => $emailForm,
            'code' => $code,
        ]);

        $this->receiver = $emailForm->getEmail();

        return $this->sendMessage();
    }

    public function sendTokenEmailMessage(EmailFormAuthenticator $emailForm)
    {
        $url = $this->router->generate(
            'mmc_user.email.login',
            ['token' => $emailForm->getEmailRequestToken()],
            routerInterface::ABSOLUTE_URL
        );

        $this->body = $this->templating->render($this->template, [
            'form' => $emailForm,
            'url' => $url,
        ]);

        $this->receiver = $emailForm->getEmail();

        return $this->sendMessage();
    }
}
