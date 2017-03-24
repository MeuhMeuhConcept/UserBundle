<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceOwnersBundle\Entity\ResourceOwners;
use MMC\User\Bundle\UserBundle\Entity\User;

class ResourceOwnersManager
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function create($response)
    {
        $user = $this->createUser();

        $resourceOwner = new ResourceOwners();

        $resourceOwner->setUser($user)
            ->setResourceOwnerId($response->getUsername())
            ->setResourceOwnerName($response->getResourceOwner()->getName())
            ->setResourceOwnerAccessToken($response->getAccessToken())
        ;

        $this->em->persist($resourceOwner);
        $this->em->flush();

        return $resourceOwner;
    }

    public function createUser()
    {
        $user = new User();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
