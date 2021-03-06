<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\Guard;

use MMC\User\Bundle\ResourceFormBundle\Form\CodeConfirmationFormType;
use MMC\User\Bundle\ResourceFormBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class ResourceFormAuthenticatorPost extends AbstractResourceFormAuthenticator
{
    protected $formFactory;

    protected $router;

    protected $resourceFormProvider;

    protected $authenticationCodeManager;

    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        ResourceFormProviderByResourceInterface $resourceFormProvider,
        AuthenticationCodeManager $authenticationCodeManager
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationCodeManager = $authenticationCodeManager;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/resource_check' && $request->isMethod('POST');

        if (!$isLoginSubmit) {
            return;
        }
        $form = $this->formFactory->create(CodeConfirmationFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();

        // $request->getSession()->set(
        //     Security::LAST_USERNAME,
        //     $data['resource']
        // );

        return $data;
    }
}
