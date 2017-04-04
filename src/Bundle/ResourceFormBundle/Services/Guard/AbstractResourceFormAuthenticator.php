<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\Guard;

use MMC\User\Bundle\EmailBundle\Services\AuthenticationCodeManager;
use MMC\User\Bundle\UserBundle\Services\UserProvider\UserProvider;
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

    abstract public function getCredentials(Request $request);

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $credentials['user'];

        return $this->userProvider->findUserById(
            [
                'user' => $user,
            ]
        );
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $code = $credentials['code'];

        if ($this->authenticationCodeManager->check($user, $code)) {
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
