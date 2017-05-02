<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\ResourceOwnersBundle\Entity\ResourceOwners as BaseResourceOwners;

/**
 * @ORM\Entity
 */
class ResourceOwners extends BaseResourceOwners
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="resourceOwners")
     */
    protected $user;
}
