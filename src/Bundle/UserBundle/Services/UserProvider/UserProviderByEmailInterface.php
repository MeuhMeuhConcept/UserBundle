<?php

namespace MMC\User\Bundle\UserBundle\Services\UserProvider;

interface UserProviderByEmailInterface
{
    public function findUserByEmail($email);
}
