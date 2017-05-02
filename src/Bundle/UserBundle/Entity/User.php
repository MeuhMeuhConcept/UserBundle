<?php

namespace MMC\User\Bundle\UserBundle\Entity;

class User implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    protected $loginForms;

    protected $resourceForms;

    protected $resourceOwners;

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
    public function getLoginForms()
    {
        return $this->loginForms;
    }

    /**
     * @param LoginFormAuthentication $loginForms
     */
    public function setLoginForms($loginForms)
    {
        $this->loginForms = $loginForms;

        return $this;
    }

    /**
     * @return ResourceFormAuthentication
     */
    public function getResourceForms()
    {
        return $this->resourceForms;
    }

    /**
     * @param ResourceFormAuthentication $resourceForms
     */
    public function setResourceForms($resourceForms)
    {
        $this->resourceForms = $resourceForms;

        return $this;
    }

    /**
     * @return LoginFormAuthenticator
     */
    public function getResourceOwners()
    {
        return $this->resourceOwners;
    }

    /**
     * @param ResourceOwners $resourceOwners
     */
    public function setResourceOwners($resourceOwners)
    {
        $this->resourceOwners = $resourceOwners;

        return $this;
    }
}
