<?php

namespace MMC\User\Bundle\ResourceFormBundle\Controller;

use MMC\User\Bundle\ResourceFormBundle\Services\Manager\RegistrationManager;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;
use MMC\User\Component\ResourceForm\Mode\ModeRegistrationInterface;
use MMC\User\Component\ResourceForm\Model\ResourceFormAuthenticationInterface;
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

    protected $modes;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        RegistrationManager $registrationManager,
        GuardAuthenticatorHandler $securityAuthenticationGuardHandler,
        GuardAuthenticatorInterface $loginFormAuthenticatorGuard,
        ResourceFormAuthenticationInterface $resourceFormAuthentication
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->registrationManager = $registrationManager;
        $this->securityAuthenticationGuardHandler = $securityAuthenticationGuardHandler;
        $this->loginFormAuthenticatorGuard = $loginFormAuthenticatorGuard;
        $this->resourceFormAuthentication = $resourceFormAuthentication;
        $this->modes = [];
    }

    public function addMode(ModeRegistrationInterface $mode)
    {
        $this->modes[$mode->getName()] = $mode;
    }

    public function registerAction(Request $request, $type)
    {
        foreach ($this->modes as $mode) {
            if ($mode->getType() == $type) {
                $modeRegistration = $mode;
            }
        }

        $mode = isset($modeRegistration) ? $modeRegistration : null;

        if (!$mode) {
            throw new NotFoundHttpException('The mode "%s" does not exist', $mode);
        }

        $form = $this->formFactory->create($mode->getFormType(), $this->resourceFormAuthentication);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->registrationManager->create($form->getData(), $mode->getType());

            return $this->templating->renderResponse('MMCResourceFormBundle:Security:check_email.html.twig');
        }

        return $this->templating->renderResponse(
            $mode->getBlockTemplate(),
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
