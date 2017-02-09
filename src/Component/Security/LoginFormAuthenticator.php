<?php

/**
 * How Authenticators Work:
 * 1 - See if the user is submitting the login form, or if this is just some random request for some random page.
 * 2 - Read the username and password from the request.
 * 3 - Load the User object from the database.
 */

namespace MMC\User\Component\Security;

use Doctrine\ORM\EntityRepository;
use MMC\User\Bundle\UserBundle\Form\LoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;

    private $repository;

    private $router;

    public function __construct(FormFactoryInterface $formFactory, EntityRepository $repository, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');

        if (!$isLoginSubmit) {
            // skip authentication
            return;
        }

        $form = $this->formFactory->create(LoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->repository->findOneBy(['email' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if ($password == 'toto') {
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
