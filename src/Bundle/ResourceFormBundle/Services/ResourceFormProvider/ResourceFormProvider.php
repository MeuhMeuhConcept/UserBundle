<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider;

use Doctrine\ORM\EntityManager;

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
        return $this->em->getRepository(EmailFormAuthentication::class)->findOneByResource($resource);
    }
}
