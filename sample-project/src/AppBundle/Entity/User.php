<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LoginFormAuthentication", mappedBy="user")
     */
    protected $loginForms;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResourceFormAuthentication", mappedBy="user")
     */
    protected $resourceForms;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResourceOwners", mappedBy="user")
     */
    protected $resourceOwners;

    public function __construct()
    {
        $this->loginForms = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
