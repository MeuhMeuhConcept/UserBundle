<?php

namespace MMC\User\Bundle\UserBundle\Services\UserProvider;

interface UserProviderByIdInterface
{
    public function findUserById($id);
}
