<?php

namespace MMCUserBundle\Component\Utils;

interface OAuthUserProviderInterface
{
    public function loadUserByOAuthUserResponse(ResourceOwnersResponseInterface $response);
}
