<?php

namespace MMC\User\Component\Controller;

use MMC\User\Bundle\LoginBundle\Form\UserRegistrationFormType;
use MMC\User\Component\Doctrine\RegistrationManager;
use MMC\User\Component\Security\LoginFormAuthenticator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            $user = $this->registrationManager->create($form->getData());

            return $this->securityAuthenticationGuardHandler
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->loginFormAuthenticator,
                    'main'
                );
        }

        return $this->templating->renderResponse(
            'MMCLoginBundle:Registration:register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function confirmAction(Request $request, $token)
    {
        $user = $this->registrationManager->findUserByConfirmationToken($token);

        if ($user != null) {
            $this->registrationManager->activateUser($user);
        } else {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        return $this->templating->renderResponse('MMCUserBundle:Registration:confirmed.html.twig');
    }
}
