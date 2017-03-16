<?php

namespace MMC\User\Component\Utils;

class OAuthUserProvider implements OAuthUserProviderInterface
{
    protected $em;

    public function __construct(
        EntityManager $em,
        array $properties
    ) {
        $this->em = $em;
        $this->properties = array_merge($this->properties, $properties);
    }

    public function loadUserByOAuthUserResponse(ResourceOwnersResponseInterface $response)
    {
        $resourceOwnersId = $response->getResourceOwnersId();
        $user = $this->em->getRepository('MMC\User\Bundle\ResourceOwnersBundle\Entity\ResourceOwners')->findOneBy([
            $this->getProperty($response) => $resourceOwnersId,
        ]);
    }
}
