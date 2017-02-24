<?php

namespace MMC\User\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Component\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="mmc_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
