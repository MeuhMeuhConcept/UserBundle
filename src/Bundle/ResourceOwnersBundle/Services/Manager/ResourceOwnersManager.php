<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceOwnersBundle\Entity\ResourceOwners;
use MMC\User\Bundle\UserBundle\Services\Manager\UserManagerInterface;
use MMC\User\Component\ResourceOwners\Model\ResourceOwnersInterface;

class ResourceOwnersManager
{
    protected $em;

    public function __construct(
        EntityManager $em,
        ResourceOwnersInterface $resourceOwners,
        UserManagerInterface $userManager
    ) {
        $this->em = $em;
        $this->resourceOwners = $resourceOwners;
        $this->userManager = $userManager;
    }

    public function create($response)
    {
        $user = $this->userManager->create();

        $resourceOwner = $this->resourceOwners;

        $resourceOwner->setUser($user)
            ->setResourceOwnerId($response->getUsername())
            ->setResourceOwnerName($response->getResourceOwner()->getName())
            ->setResourceOwnerAccessToken($response->getAccessToken())
        ;

        $this->em->persist($resourceOwner);
        $this->em->flush();

        return $resourceOwner;
    }
}
