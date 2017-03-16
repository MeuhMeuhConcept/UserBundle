<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Entity;

class ResourceOwners
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
    protected $resourceOwnersId;

    /**
     * @var string
     */
    protected $resourceOwnersIdType = 'trello';

    /**
     * @var string
     */
    protected $resourceOwnersAccessToken;

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
    public function getResourceOwnersId()
    {
        return $this->resourceOwnersId;
    }

    /**
     * @param string $trelloId
     */
    public function setResourceOwnersId($resourceOwnersId)
    {
        $this->resourceOwnersId = $resourceOwnersId;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceOwnersIdType()
    {
        return $this->resourceOwnersIdType;
    }

    /**
     * @param string $trelloId
     */
    public function setResourceOwnersIdType($resourceOwnersIdType)
    {
        $this->resourceOwnersIdType = $resourceOwnersIdType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrelloAccessToken()
    {
        return $this->trelloAccessToken;
    }

    /**
     * @param string $trelloAccessToken
     */
    public function setTrelloAccessToken($trelloAccessToken)
    {
        $this->trelloAccessToken = $trelloAccessToken;

        return $this;
    }
}
