<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services;

interface OAuthUserProviderInterface
{
    public function loadUserByOAuthUserResponse(ResourceOwnersResponseInterface $response);
}
