<?php

namespace MMC\User\Bundle\UserBundle\Services\UserProvider;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\EmailBundle\Entity\EmailFormAuthentication;
use MMC\User\Bundle\UserBundle\Entity\User;

class UserProvider implements UserProviderByIdInterface, UserProviderByEmailInterface
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function findUserById($id)
    {
        return $this->em->getRepository(User::class)->findOneById($id);
    }

    public function findUserByEmail($email)
    {
        return $this->em->getRepository(EmailFormAuthentication::class)->findOneByEmail($email);
    }
}
