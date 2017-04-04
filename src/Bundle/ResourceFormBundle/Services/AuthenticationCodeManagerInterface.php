<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthenticationInterface;

interface AuthenticationCodeManagerInterface
{
    public function generate(ResourceFormAuthenticationInterface $user);

    public function check(ResourceFormAuthenticationInterface $user, $code, $test = false);
}
