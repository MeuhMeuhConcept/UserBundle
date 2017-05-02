<?php

namespace MMC\User\Bundle\UserBundle\Services\Manager;

use AppBundle\Entity\User;
//use MMC\User\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserManager implements UserManagerInterface
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function create($flush = true)
    {
        $user = new User();

        $this->em->persist($user);

        if ($flush) {
            $this->em->flush();
        }

        return $user;
    }
}
