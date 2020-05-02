<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Entity;

use MMC\User\Component\ResourceOwners\Model\ResourceOwnersInterface;

class ResourceOwners implements ResourceOwnersInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $user;

    /**
     * @var string
     */
    protected $resourceOwnerName;

    /**
     * @var int
     */
    protected $resourceOwnerId;

    /**
     * @var string
     */
    protected $resourceOwnerAccessToken;

    /**
     * @return int
     *             {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceOwnerName()
    {
        return $this->resourceOwnerName;
    }

    /**
     * @param string $trelloId
     */
    public function setResourceOwnerName($resourceOwnerName)
    {
        $this->resourceOwnerName = $resourceOwnerName;

        return $this;
    }

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    /**
     * @param type $resourceOwnerId
     */
    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceOwnerAccessToken()
    {
        return $this->resourceOwnerAccessToken;
    }

    /**
     * @param string $resourceOwnerAccessToken
     */
    public function setResourceOwnerAccessToken($resourceOwnerAccessToken)
    {
        $this->resourceOwnerAccessToken = $resourceOwnerAccessToken;

        return $this;
    }
}
