<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication as BaseResourceFormAuthentication;

/**
 * @ORM\Entity
 */
class ResourceFormAuthentication extends BaseResourceFormAuthentication
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="resourceForms")
     */
    protected $user;
}
