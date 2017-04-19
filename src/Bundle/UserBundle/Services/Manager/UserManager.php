<?php

namespace MMC\User\Bundle\UserBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\UserBundle\Entity\User;

class UserManager implements UserManagerInterface
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function create()
    {
        $user = new User();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
