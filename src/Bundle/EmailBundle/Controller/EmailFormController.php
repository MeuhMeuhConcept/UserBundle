<?php

namespace MMC\User\Bundle\EmailBundle\Controller;

use MMC\User\Bundle\EmailBundle\Form\CodeConfirmationFormType;
use MMC\User\Bundle\EmailBundle\Form\EmailFormType;
use MMC\User\Bundle\EmailBundle\Form\EmailRegistrationFormType;
use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\UserBundle\Services\UserProvider\UserProvider;
use MMC\User\Component\Mailer\CodeSender;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
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

    protected $codeSender;

    protected $userProvider;

    protected $securityAuthenticationGuardHandler;

    protected $emailFormAuthenticator;

    protected $renderTemplate;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationCodeManager $authenticationCodeManager,
        CodeSender $codeSender,
        UserProvider $userProvider,
        AuthenticationParametersConverterInterface $authenticationParametersConverter,
        $renderTemplate
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->codeSender = $codeSender;
        $this->userProvider = $userProvider;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
        $this->renderTemplate = $renderTemplate;
    }

    public function sendCodeAction(Request $request)
    {
        $form = $this->formFactory->create(EmailFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userProvider->findUserByEmail($form->getData());

            if ($user != null) {
                $code = $this->authenticationCodeManager->generate($user);

                //$codeConvert = $this->authenticationParametersConverter->convert($user->getUser()->getId(), $code);

                $this->codeSender->sendCode($user, $code);

                $codeConfirmationForm = $this->formFactory->create(CodeConfirmationFormType::class);

                return $this->templating->renderResponse(
                    $this->renderTemplate,
                    [
                        'form' => $codeConfirmationForm->createView(),
                        'user' => $user->getUser()->getId(),
                        'email' => $user->getEmail(),
                    ]
                );
            }
        }

        return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
    }

    /*public function sendUrlAction(Request $request)
    {
        $form = $this->formFactory->create(EmailFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userProvider->findUserByEmail($form->getData());

            if ($user != null) {
                $code = $this->authenticationCodeManager->generate($user);
                $codeConvert = $this->authenticationParametersConverter->convert($user->getUser()->getId(), $code);

                $this->messageSenderWithUrl->sendCode($user, $codeConvert);

                return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
            } else {
                return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
            }
        }

        return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
    }*/

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
