<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;

class ResourceFormProvider implements ResourceFormProviderByResourceInterface
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function findUserByResource($resource)
    {
        return $this->em->getRepository(ResourceFormAuthentication::class)->findOneByResource($resource);
    }

    public function findResourceByType($resource, $type)
    {
        return $this->em->getRepository(ResourceFormAuthentication::class)->findOneBy(['resource' => $resource, 'type' => $type]);
    }
}
