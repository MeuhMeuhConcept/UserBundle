<?php

namespace MMC\User\Bundle\ResourceFormBundle\Controller;

use Mmc\Processor\Component\Processor;
use Mmc\Processor\Component\Request as MmcProcessorRequest;
use MMC\User\Bundle\ResourceFormBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use MMC\User\Component\ResourceForm\Mode\ModeControllerInterface;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ResourceFormController
{
    protected $router;

    protected $templating;

    protected $formFactory;

    protected $authenticationCodeManager;

    protected $codeSender;

    protected $resourceFormProvider;

    protected $modes;

    protected $session;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        AuthenticationCodeManager $authenticationCodeManager,
        Processor $resourceSenderProcessor,
        ResourceFormProviderByResourceInterface $resourceFormProvider,
        AuthenticationParametersConverterInterface $authenticationParametersConverter,
        TranslatorInterface $translator,
        AuthenticationUtils $authenticationUtils,
        Session $session
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->resourceSenderProcessor = $resourceSenderProcessor;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
        $this->modes = [];
        $this->translator = $translator;
        $this->authenticationUtils = $authenticationUtils;
        $this->session = $session;
    }

    public function addMode(ModeControllerInterface $mode)
    {
        $this->modes[$mode->getName()] = $mode;
    }

    public function sendAction(Request $request, $type)
    {
        foreach ($this->modes as $mode) {
            if ($mode->getType() == $type) {
                $modeController = $mode;
            }
        }

        $mode = isset($modeController) ? $modeController : null;

        if (!$mode) {
            throw new NotFoundHttpException('The mode "%s" does not exist', $mode);
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();

        $form = $this->formFactory->create($mode->getFormType());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $resourceForm = $this->resourceFormProvider->findResourceByType(
                $data['resource'],
                array_merge(['type' => $mode->getType()])
            );

            if ($resourceForm != null) {
                $code = $this->authenticationCodeManager->generate($resourceForm);

                $codeConvert = $this->authenticationParametersConverter->convert($resourceForm->getId(), $code);

                $url = $this->router->generate(
                    'mmc_user.resource_form.authenticator',
                    ['token' => $codeConvert],
                    routerInterface::ABSOLUTE_URL
                );

                $urlForm = $this->router->generate(
                    'mmc_user.resource_form.form',
                    ['id' => $resourceForm->getId()],
                    routerInterface::ABSOLUTE_URL
                );

                $content = $this->templating->render($mode->getMessageTemplate(), [
                    'resourceForm' => $resourceForm,
                    'url' => $url,
                    'urlForm' => $urlForm,
                    'code' => $code,
                ]);

                $subject = $this->translator->trans($mode->getMessageSubject());

                $response = $this->resourceSenderProcessor->process(new MmcProcessorRequest([
                    'name' => $mode->getName(),
                    'type' => $mode->getType(),
                    'resource' => $resourceForm,
                    'subject' => $subject,
                    'content' => $content,
                ]));

                //Flash en fonction de la response

                return new RedirectResponse($this->router->generate(
                    'mmc_user.resource_form.render',
                    [
                        'id' => $resourceForm->getId(),
                        'type' => $mode->getType(),
                    ]
                ));
            }

            $this->session->getFlashBag()->add('error', 'Bad credential');
        }

        //render Page avec blockTemplate et $form (ça affichera les erreurs)
        return $this->templating->renderResponse(
            $mode->getBlockTemplate(),
            [
                'form' => $form->createView(),
                'type' => $mode->getType(),
                'error' => $error,
                'back' => true,
            ]
        );
    }
}
