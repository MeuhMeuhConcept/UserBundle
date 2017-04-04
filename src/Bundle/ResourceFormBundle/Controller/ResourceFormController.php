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
        array $formModes
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->codeSender = $codeSender;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
        $this->formModes = $formModes;
    }

    public function sendCodeAction(Request $request)
    {
        $form = $this->formFactory->create(EmailFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->resourceFormProvider->findUserByEmail($form->getData());

            if ($user != null) {
                $code = $this->authenticationCodeManager->generate($user);

                //$codeConvert = $this->authenticationParametersConverter->convert($user->getUser()->getId(), $code);

                $this->codeSender->sendCode($user, $code);

                $codeConfirmationForm = $this->formFactory->create(CodeConfirmationFormType::class);

                return $this->templating->renderResponse(
                    $this->renderTemplate,
                    [
                        'form' => $codeConfirmationForm->createView(),
                        'user' => $user->getUser()->getId(),
                        'email' => $user->getEmail(),
                    ]
                );
            }
        }

        return new RedirectResponse($this->router->generate('mmc_user.login'), 302);
    }
}
