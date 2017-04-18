<?php

namespace MMC\User\Bundle\LoginFormBundle\Entity;

use MMC\User\Component\LoginForm\Model\LoginFormAuthenticationInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields="login", message="Cet identifiant est déjà utilisé.")
 */
class LoginFormAuthentication implements UserInterface, LoginFormAuthenticationInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     * @Assert\NotBlank(groups={"Registration"})
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var \Ramsey\Uuid\Uuid
     */
    protected $confirmationToken;

    /**
     * @var \Ramsey\Uuid\Uuid
     */
    protected $passwordRequestToken;

    /**
     * @var int
     */
    protected $user;

    /**
     * @return int
     *             {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     *                      {@inheritdoc}
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *                         {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $login
     *                      {@inheritdoc}
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *                     {@inheritdoc}
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param \Ramsey\Uuid\Uuid $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getPasswordRequestToken()
    {
        return $this->passwordRequestToken;
    }

    /**
     * @param \Ramsey\Uuid\Uuid $passwordRequestToken
     */
    public function setPasswordRequestToken($passwordRequestToken)
    {
        $this->passwordRequestToken = $passwordRequestToken;

        return $this;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
