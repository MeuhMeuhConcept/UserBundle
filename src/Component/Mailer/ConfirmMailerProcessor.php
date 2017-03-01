<?php

namespace MMC\User\Component\Mailer;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface as LoginFormAuthenticatorInterface;

class ConfirmMailerProcessor extends MailerProcessor
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

    public function sendConfirmationEmailMessage(LoginFormAuthenticatorInterface $loginForm)
    {
        $url = $this->router->generate(
            'mmc_user.registration_confirmation',
            ['token' => $loginForm->getConfirmationToken()],
            routerInterface::ABSOLUTE_URL
        );

        $this->body = $this->templating->render($this->template, [
            'form' => $loginForm,
            'url' => $url
        ]);

        $this->receiver = $loginForm->getEmail();

        return $this->sendMessage();
    }
}
