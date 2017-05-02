<?php

namespace MMC\User\Bundle\UserBundle\Services\Manager;

interface UserManagerInterface
{
    public function create($flush = true);
}
