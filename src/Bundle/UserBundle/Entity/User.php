<?php

namespace MMC\User\Bundle\UserBundle\Entity;

class User implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    protected $loginFormAuthenticator;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return LoginFormAuthenticator
     */
    public function getLoginFormAuthenticator()
    {
        return $this->loginFormAuthenticator;
    }

    /**
     * @param LoginFormAuthenticator $loginFormAuthenticator
     */
    public function setLoginFormAuthenticator($loginFormAuthenticator)
    {
        $this->loginFormAuthenticator = $loginFormAuthenticator;

        return $this;
    }
}
