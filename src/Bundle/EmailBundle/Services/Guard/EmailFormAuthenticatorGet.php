<?php

namespace MMC\User\Bundle\EmailBundle\Services\Guard;

use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\UserBundle\Services\UserProvider\UserProvider;
use MMC\User\Component\Security\AuthenticationParametersConverter\AuthenticationParametersConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class EmailFormAuthenticatorGet extends AbstractEmailFormAuthenticator
{
    protected $formFactory;

    protected $router;

    protected $userProvider;

    protected $authenticationCodeManager;

    protected $authenticationParametersConverter;

    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        UserProvider $userProvider,
        AuthenticationCodeManager $authenticationCodeManager,
        AuthenticationParametersConverterInterface $authenticationParametersConverter
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->userProvider = $userProvider;
        $this->authenticationCodeManager = $authenticationCodeManager;
        $this->authenticationParametersConverter = $authenticationParametersConverter;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/email_check' && $request->isMethod('GET');

        if (!$isLoginSubmit) {
            return;
        }

        $data = $this->authenticationParametersConverter->revert($request->query->get('token'));

        return $data;
    }
}
