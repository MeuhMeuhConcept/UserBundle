<?php

namespace MMC\User\Component\Doctrine;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\UserBundle\Entity\User;
use Ramsey\Uuid\Uuid;

class RegistrationManager
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function create($loginFormAuthenticator)
    {
        $user = $this->createUser();

        $loginFormAuthenticator->setUser($user)
            ->setConfirmationToken(Uuid::uuid4())
        ;

        $this->em->persist($loginFormAuthenticator);
        $this->em->flush();

        return $loginFormAuthenticator;
    }

    public function createUser()
    {
        $user = new User();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
