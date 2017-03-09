<?php

namespace MMC\User\Component\Utils;

use MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator;

class LoginFormAuthenticatorManipulator
{
    public function create($login, $password)
    {
        $loginFormAuthenticator = new LoginFormAuthenticator();
        $loginFormAuthenticator->setLogin($login)
            ->setPlainPassword($password)
        ;

        return $loginFormAuthenticator;
    }
}
