<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\LoginFormBundle\Entity\LoginFormAuthentication as BaseLoginFormAuthentication;

/**
 * @ORM\Entity
 */
class LoginFormAuthentication extends BaseLoginFormAuthentication
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="loginForms")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
}
