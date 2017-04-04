<?php

namespace MMC\User\Bundle\ResourceFormBundle\Controller;

use MMC\User\Bundle\ResourceFormBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use MMC\User\Component\Mailer\CodeSender;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class ResourceFormController
{
    protected $router;

    protected $templating;

    protected $formFactory;

    protected $authenticationCodeManager;

    protected $codeSender;

    protected $resourceFormProvider;

    protected $renderTemplate;

    protected $formType;

    protected $formTemplate;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationCodeManager $authenticationCodeManager,
        CodeSender $codeSender,
        ResourceFormProviderByResourceInterface $resourceFormProvider,
        AuthenticationParametersConverterInterface $authenticationParametersConverter,
        string $formType,
        string $formTemplate,
        $renderTemplate
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->codeSender = $codeSender;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
        $this->formType = $formType;
        $this->formTemplate = $formTemplate;
        $this->renderTemplate = $renderTemplate;
    }

    public function sendCodeAction(Request $request)
    {
        $form = $this->formFactory->create($this->formType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resourceForm = $this->resourceFormProvider->findUserByResource($form->getData());

            if ($resourceForm != null) {
                $code = $this->authenticationCodeManager->generate($resourceForm);

                //$codeConvert = $this->authenticationParametersConverter->convert($user->getUser()->getId(), $code);

                $this->codeSender->sendCode($resourceForm, $code);

                $codeConfirmationForm = $this->formFactory->create($this->formTemplate);

                return $this->templating->renderResponse(
                    $this->renderTemplate,
                    [
                        'form' => $codeConfirmationForm->createView(),
                        'user' => $resourceForm->getUser()->getId(),
                    ]
                );
            }

            return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
        }

        return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
    }
}
