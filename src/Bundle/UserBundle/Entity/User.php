<?php

namespace MMC\User\Bundle\UserBundle\Entity;

class User implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    protected $loginForm;

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
    public function getLoginForm()
    {
        return $this->loginForm;
    }

    /**
     * @param LoginFormAuthenticator $loginForm
     */
    public function setLoginForm($loginForm)
    {
        $this->loginForm = $loginForm;
        return $this;
    }
}
