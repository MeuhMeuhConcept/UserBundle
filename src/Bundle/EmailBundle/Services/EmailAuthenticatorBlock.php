<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use MMC\User\Bundle\EmailBundle\Form\EmailFormType;
use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\AuthenticatorBlock;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;

class EmailAuthenticatorBlock implements AuthenticatorBlock
{
    protected $isMain;
    protected $templating;
    protected $tokenManager;
    protected $formFactory;
    protected $authenticationUtils;

    public function __construct(
        bool $isMain,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationUtils $authenticationUtils
    ) {
        $this->isMain = $isMain;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function render()
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $form = $this->formFactory->create(EmailFormType::class);

        return $this->templating->render(
            'MMCEmailBundle:Security:email_block.html.twig',
            [
                'form_email' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    public function getIsMain()
    {
        return $this->isMain;
    }
}
