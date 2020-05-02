<?php

namespace MMC\User\Bundle\ResourceFormBundle\Controller;

use Mmc\Processor\Component\Processor;
use MMC\User\Bundle\ResourceFormBundle\Form\CodeConfirmationFormType;
use MMC\User\Bundle\ResourceFormBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use MMC\User\Component\ResourceForm\Mode\ModeRenderInterface;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class RenderFormController
{
    protected $router;

    protected $templating;

    protected $formFactory;

    protected $authenticationCodeManager;

    protected $codeSender;

    protected $resourceFormProvider;

    protected $modes;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationCodeManager $authenticationCodeManager,
        Processor $resourceSenderProcessor,
        ResourceFormProviderByResourceInterface $resourceFormProvider,
        AuthenticationParametersConverterInterface $authenticationParametersConverter
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->resourceSenderProcessor = $resourceSenderProcessor;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
        $this->modes = [];
    }

    public function addMode(ModeRenderInterface $mode)
    {
        $this->modes[$mode->getName()] = $mode;
    }

    public function renderAction(Request $request, $type, $id)
    {
        foreach ($this->modes as $mode) {
            if ($mode->getType() == $type) {
                $modeRender = $mode;
            }
        }

        $mode = isset($modeRender) ? $modeRender : null;

        if (!$mode) {
            throw new NotFoundHttpException('The mode "%s" does not exist', $mode);
        }

        $form = $this->formFactory->create(CodeConfirmationFormType::class);

        $form->handleRequest($request);

        return $this->templating->renderResponse(
            $mode->getRenderTemplate(),
            [
                'form' => $form->createView(),
                'id' => $id,
            ]
        );
    }
}
