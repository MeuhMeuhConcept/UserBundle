<?php

namespace MMC\User\Bundle\EmailBundle\Controller;

use MMC\User\Bundle\EmailBundle\Form\CodeConfirmationFormType;
use MMC\User\Bundle\EmailBundle\Form\EmailFormType;
use MMC\User\Bundle\EmailBundle\Form\EmailRegistrationFormType;
use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\UserBundle\Services\UserProvider\UserProvider;
use MMC\User\Component\Mailer\MailerProcessor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailFormController
{
    protected $router;

    protected $templating;

    protected $formFactory;

    protected $authenticationCodeManager;

    protected $mailerProcessor;

    protected $userProvider;

    protected $securityAuthenticationGuardHandler;

    protected $emailFormAuthenticator;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationCodeManager $authenticationCodeManager,
        MailerProcessor $mailerProcessor,
        UserProvider $userProvider
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->mailerProcessor = $mailerProcessor;
        $this->userProvider = $userProvider;
    }

    public function sendCodeAction(Request $request)
    {
        $form = $this->formFactory->create(EmailFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userProvider->findUserByEmail($form->getData());

            if ($user != null) {
                $code = $this->authenticationCodeManager->generate($user);

                $this->mailerProcessor->sendEmailWithCode($user, $code);

                $codeConfirmationForm = $this->formFactory->create(CodeConfirmationFormType::class);

                return $this->templating->renderResponse(
                    'MMCEmailBundle:Security:code_confirmation.html.twig',
                    [
                        'form' => $codeConfirmationForm->createView(),
                        'user' => $user->getUser()->getId(),
                        'email' => $user->getEmail(),
                    ]
                );
            } else {
                return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
            }
        }

        return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
    }

    public function registrationAction(Request $request)
    {
        $form = $this->formFactory->create(EmailRegistrationFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->emailManager->create($form->getData());

            //TODO
            return;
        }

        return $this->templating->renderResponse(
            'MMCEmailBundle:Registration:registration.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
