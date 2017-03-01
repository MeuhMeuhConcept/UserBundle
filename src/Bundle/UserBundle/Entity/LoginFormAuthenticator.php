<?php

namespace MMC\User\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Component\Model\LoginFormAuthenticator as BaseLoginFormAuthenticator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="mmc_login_form_authenticator")
 * @UniqueEntity("email")
 */
class LoginFormAuthenticator extends BaseLoginFormAuthenticator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $salt;

    /**
     * @ORM\OneToOne(targetEntity="User", cascade={"persist"})
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="uuid")
     */
    protected $confirmationToken;

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
