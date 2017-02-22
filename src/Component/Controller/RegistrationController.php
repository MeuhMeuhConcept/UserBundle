<?php

namespace MMC\User\Component\Controller;

use MMC\User\Bundle\UserBundle\Form\UserRegistrationFormType;
use MMC\User\Component\Doctrine\RegistrationManager;
use MMC\User\Component\Security\LoginFormAuthenticator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Templating\EngineInterface;

class RegistrationController
{
    protected $router;
    protected $templating;
    protected $formFactory;
    protected $registrationManager;
    protected $securityAuthenticationGuardHandler;
    protected $loginFormAuthenticator;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        RegistrationManager $registrationManager,
        GuardAuthenticatorHandler $securityAuthenticationGuardHandler,
        LoginFormAuthenticator $loginFormAuthenticator
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->registrationManager = $registrationManager;
        $this->securityAuthenticationGuardHandler = $securityAuthenticationGuardHandler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
    }

    public function registerAction(Request $request)
    {
        $form = $this->formFactory->create(UserRegistrationFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->processForm($request, $form);

            return $this->securityAuthenticationGuardHandler
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->loginFormAuthenticator,
                    'main'
                );
        }

        return $this->templating->renderResponse(
            'MMCUserBundle:Registration:register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    protected function processForm(Request $request, $form)
    {
        return $this->registrationManager->create($form);
    }
}
