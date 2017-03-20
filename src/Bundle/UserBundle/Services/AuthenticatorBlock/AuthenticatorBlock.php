<?php

namespace MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock;

interface AuthenticatorBlock
{
    public function render();
    public function getIsMain();
}
