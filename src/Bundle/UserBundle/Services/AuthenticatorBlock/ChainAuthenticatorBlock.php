<?php

namespace MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock;

class ChainAuthenticatorBlock
{
    protected $authenticatorBlocks;

    public function __construct()
    {
        $this->authenticatorBlocks = [];
    }

    public function addAuthenticatorBlocks(AuthenticatorBlock $authenticatorBlock)
    {
        $this->authenticatorBlocks[] = $authenticatorBlock;
    }

    public function getAuthenticatorBlocks()
    {
        return $this->authenticatorBlocks;
    }
}
