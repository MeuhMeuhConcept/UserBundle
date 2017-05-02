<?php

namespace MMC\User\Bundle\LoginFormBundle\Controller;

use MMC\User\Bundle\LoginFormBundle\Form\LoginFormRegistrationFormType;
use MMC\User\Bundle\LoginFormBundle\Services\Manager\RegistrationManager;
use MMC\User\Component\LoginForm\Model\LoginFormAuthenticationInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;
use Symfony\Component\Templating\EngineInterface;

class RegistrationController
{
    protected $router;

    protected $templating;

    protected $formFactory;

    protected $registrationManager;

    protected $securityAuthenticationGuardHandler;

    protected $loginFormAuthenticatorGuard;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        RegistrationManager $registrationManager,
        GuardAuthenticatorHandler $securityAuthenticationGuardHandler,
        GuardAuthenticatorInterface $loginFormAuthenticatorGuard,
        LoginFormAuthenticationInterface $loginFormAuthentication
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->registrationManager = $registrationManager;
        $this->securityAuthenticationGuardHandler = $securityAuthenticationGuardHandler;
        $this->loginFormAuthenticatorGuard = $loginFormAuthenticatorGuard;
        $this->loginFormAuthentication = $loginFormAuthentication;
    }

    public function registerAction(Request $request)
    {
        //USerFactory qui crée les User et le manager les save
        $form = $this->formFactory->create(LoginFormRegistrationFormType::class, $this->loginFormAuthentication);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->registrationManager->create($form->getData());

            return $this->securityAuthenticationGuardHandler
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->loginFormAuthenticatorGuard,
                    'main'
                );
        }

        return $this->templating->renderResponse(
            'MMCLoginFormBundle:Registration:registration_block.html.twig',
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
