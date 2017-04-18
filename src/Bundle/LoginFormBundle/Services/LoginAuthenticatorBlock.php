<?php

namespace MMC\User\Bundle\LoginFormBundle\Services;

use MMC\User\Bundle\LoginFormBundle\Form\LoginFormType;
use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\AuthenticatorBlock;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;

class LoginAuthenticatorBlock implements AuthenticatorBlock
{
    protected $isMain;
    protected $templating;
    protected $authenticationUtils;

    public function __construct(
        bool $isMain,
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory
    ) {
        $this->isMain = $isMain;
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
        $this->formFactory = $formFactory;
    }

    public function render()
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        $form = $this->formFactory->create(LoginFormType::class, [
            '_username' => $lastUsername,
        ]);

        return $this->templating->render(
            'MMCLoginFormBundle:Security:login_block.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    public function getIsMain()
    {
        return $this->isMain;
    }
}
