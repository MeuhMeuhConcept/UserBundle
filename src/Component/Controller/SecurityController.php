<?php

namespace MMC\User\Component\Controller;

use MMC\User\Bundle\UserBundle\Form\LoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;

class SecurityController
{
    protected $router;
    protected $templating;
    protected $authenticationUtils;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
        $this->formFactory = $formFactory;
    }

    public function loginAction()
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        $form = $this->formFactory->create(LoginFormType::class, [
            '_username' => $lastUsername,
        ]);

        return $this->templating->renderResponse(
            'MMCUserBundle:Security:login.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
