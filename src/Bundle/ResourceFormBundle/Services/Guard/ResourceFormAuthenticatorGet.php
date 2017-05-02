<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\Guard;

use MMC\User\Bundle\ResourceFormBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ResourceFormAuthenticatorGet extends AbstractResourceFormAuthenticator
{
    protected $formFactory;

    protected $router;

    protected $resourceFormProvider;

    protected $authenticationCodeManager;

    protected $authenticationParametersConverter;

    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        ResourceFormProviderByResourceInterface $resourceFormProvider,
        AuthenticationCodeManager $authenticationCodeManager,
        AuthenticationParametersConverterInterface $authenticationParametersConverter
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->resourceFormProvider = $resourceFormProvider;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/resource_check' && $request->isMethod('GET');

        if (!$isLoginSubmit) {
            return;
        }

        $data = $this->authenticationParametersConverter->revert($request->query->get('token'));

        return $data;
    }
}
