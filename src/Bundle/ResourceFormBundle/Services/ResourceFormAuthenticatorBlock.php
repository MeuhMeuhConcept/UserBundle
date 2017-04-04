<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use MMC\User\Bundle\EmailBundle\Form\EmailFormType;
use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\AuthenticatorBlock;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;

class ResourceFormAuthenticatorBlock implements AuthenticatorBlock
{
    protected $isMain;

    protected $templating;

    protected $tokenManager;

    protected $formFactory;

    protected $authenticationUtils;

    protected $resourceForms;

    public function __construct(
        bool $isMain,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationUtils $authenticationUtils,
        array $resourceForms
    ) {
        $this->isMain = $isMain;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
        $this->resourceForms = $resourceForms;
    }

    public function render()
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $form = $this->formFactory->create(EmailFormType::class);

        return $this->templating->render(
            'MMCResourceFormBundle:Security:resource_form_block.html.twig',
            [
                'form_email' => $form->createView(),
                'error' => $error,
                'resourceForms' => $this->resourceForms,
            ]
        );
    }

    public function getIsMain()
    {
        return $this->isMain;
    }
}
