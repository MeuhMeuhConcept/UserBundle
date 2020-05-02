<?php

namespace MMC\User\Component\ResourceOwners\Model;

interface ResourceOwnersInterface
{
    public function getResourceOwnerName();

    public function getResourceOwnerId();

    public function getResourceOwnerAccessToken();
}
