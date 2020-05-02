<?php

namespace MMC\User\Bundle\LoginFormBundle\Services\Block;

use MMC\User\Bundle\LoginFormBundle\Form\LoginFormRegistrationFormType;
use MMC\User\Bundle\UserBundle\Services\RegistrationBlock\RegistrationBlockInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;

class RegistrationBlock implements RegistrationBlockInterface
{
    protected $templating;
    protected $authenticationUtils;

    public function __construct(
        EngineInterface $templating,
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory
    ) {
        $this->templating = $templating;
        $this->authenticationUtils = $authenticationUtils;
        $this->formFactory = $formFactory;
    }

    public function render()
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        $form = $this->formFactory->create(LoginFormRegistrationFormType::class);

        return $this->templating->render(
            'MMCLoginFormBundle:Registration:registration_block.html.twig',
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
