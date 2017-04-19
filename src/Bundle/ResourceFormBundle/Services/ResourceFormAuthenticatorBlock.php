<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\AuthenticatorBlock;
use MMC\User\Component\ResourceForm\Mode\ModeBlockInterface;
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

    protected $modes;

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
        $this->modes = [];
    }

    public function addMode(ModeBlockInterface $mode)
    {
        $this->modes[$mode->getName()] = $mode;
    }

    public function render()
    {
        $resourceForms = $this->renderTemplate();

        return $this->templating->render(
            'MMCResourceFormBundle:Security:resource_form_block.html.twig',
            [
                'resourceForms' => $resourceForms,
            ]
        );
    }

    public function renderTemplate()
    {
        $contents = [];

        foreach ($this->modes as $mode) {
            $error = $this->authenticationUtils->getLastAuthenticationError();

            $form = $this->formFactory->create($mode->getFormType());

            $content = $this->templating->render(
                $mode->getBlockTemplate(),
                [
                    'form' => $form->createView(),
                    'type' => $mode->getType(),
                    'error' => $error,
                ]
            );

            $contents[$mode->getName()] = $content;
        }

        return $contents;
    }

    public function getIsMain()
    {
        return $this->isMain;
    }
}
