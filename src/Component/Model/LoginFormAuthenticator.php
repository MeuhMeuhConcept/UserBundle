<?php

namespace MMC\User\Component\Model;

use Symfony\Component\Security\Core\User\UserInterface as LoginFormAuthenticatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class LoginFormAuthenticator implements LoginFormAuthenticatorInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

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
        return $this->email;
    }

    /**
     * @return string
     *                {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *                      {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
     * @param string $email
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
}
