<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services\ResourceOwnersProvider;

use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthUserProvider implements OAuthAwareUserProviderInterface
{
    protected $em;

    protected $properties = [
        'identifier' => 'id',
    ];

    protected $resourceOwnersManager;

    public function __construct(
        EntityManager $em,
        array $properties,
        $resourceOwnersManager
    ) {
        $this->em = $em;
        $this->properties = array_merge($this->properties, $properties);
        $this->resourceOwnersManager = $resourceOwnersManager;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnersId = $response->getUsername();

        $resourceOwner = $this->em->getRepository('MMC\User\Bundle\ResourceOwnersBundle\Entity\ResourceOwners')->findOneBy([
            $this->getProperty($response) => $resourceOwnersId,
        ]);

        if (null === $resourceOwner) {
            //creation de l'user
            $resourceOwner = $this->resourceOwnersManager->create($response);
        }

        $user = $resourceOwner->getUser();

        return $user;
    }

    protected function getProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->properties[$resourceOwnerName];
    }
}
