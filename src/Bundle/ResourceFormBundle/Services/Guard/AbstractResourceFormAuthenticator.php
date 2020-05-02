<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\Guard;

use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider\ResourceFormProviderByResourceInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

abstract class AbstractResourceFormAuthenticator extends AbstractFormLoginAuthenticator
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

    abstract public function getCredentials(Request $request);

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $resourceId = $credentials['user'];

        return $this->resourceFormProvider->findUserById(
            [
                'id' => $resourceId,
            ]
        );
    }

    public function checkCredentials($credentials, UserInterface $resourceForm)
    {
        $code = $credentials['code'];

        if ($this->authenticationCodeManager->check($resourceForm, $code)) {
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('mmc_user.login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}
