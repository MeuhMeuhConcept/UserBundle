<?php

namespace MMC\User\Component\Utils;

use MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator;

class LoginFormAuthenticatorManipulator
{
    public function create($email, $password)
    {
        $loginFormAuthenticator = new LoginFormAuthenticator();
        $loginFormAuthenticator->setEmail($email)
            ->setPlainPassword($password)
        ;

        return $loginFormAuthenticator;
    }
}
