<?php

namespace MMC\User\Bundle\UserBundle\Services\RegistrationBlock;

class ChainRegistrationBlock
{
    protected $registrationBlocks;

    public function __construct()
    {
        $this->registrationBlocks = [];
    }

    public function addRegistrationBlocks(RegistrationBlockInterface $registrationBlock)
    {
        $this->registrationBlocks[] = $registrationBlock;
    }

    public function getRegistrationBlocks()
    {
        return $this->registrationBlocks;
    }
}
