<?php

namespace MMC\User\Bundle\UserBundle\Entity;

class User implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    protected $loginFormAuthenticator;

    protected $emailFormAuthenticator;

    protected $resourceOwnerAuthenticator;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
    }

    public function eraseCredentials()
    {
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

    /**
     * @return EmailFormAuthenticator
     */
    public function getEmailFormAuthenticator()
    {
        return $this->emailFormAuthenticator;
    }

    /**
     * @param EmailFormAuthenticator $emailFormaAuthenticator
     */
    public function setEmailFormaAuthenticator($emailFormaAuthenticator)
    {
        $this->emailFormaAuthenticator = $emailFormaAuthenticator;

        return $this;
    }

    /**
     * @return LoginFormAuthenticator
     */
    public function getResourceOwnerAuthenticator()
    {
        return $this->resourceOwnerAuthenticator;
    }

    /**
     * @param ResourceOwnerAuthenticator $resourceOwnerAuthenticator
     */
    public function setResourceOwnerAuthenticator($resourceOwnerAuthenticator)
    {
        $this->resourceOwnerAuthenticator = $resourceOwnerAuthenticator;

        return $this;
    }
}
