<?php

namespace MMC\User\Bundle\EmailBundle\Services\Guard;

use MMC\User\Bundle\EmailBundle\Form\CodeConfirmationFormType;
use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\UserBundle\Services\UserProvider\UserProvider;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class EmailFormAuthenticatorGet extends AbstractEmailFormAuthenticator
{
    protected $formFactory;

    protected $router;

    protected $userProvider;

    protected $authenticationCodeManager;

    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        UserProvider $userProvider,
        AuthenticationCodeManager $authenticationCodeManager
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->userProvider = $userProvider;
        $this->authenticationCodeManager = $authenticationCodeManager;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/email_check' && $request->isMethod('GET');

        if (!$isLoginSubmit) {
            return;
        }
        $form = $this->formFactory->create(CodeConfirmationFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['email']
        );

        return $data;
    }
}
