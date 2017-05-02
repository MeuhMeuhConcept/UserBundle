<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services\ResourceOwnersProvider;

interface OAuthUserProviderInterface
{
    public function loadUserByOAuthUserResponse(ResourceOwnersResponseInterface $response);
}
