<?php

namespace MMC\User\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Component\Model\LoginFormAuthenticator as BaseLoginFormAuthenticator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="mmc_login_form_authenticator")
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
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @ORM\OneToOne(targetEntity="User", cascade={"persist"})
     */
    private $user;
}
