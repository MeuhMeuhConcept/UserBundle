<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use Symfony\Component\Security\Core\User\UserInterface;

interface AuthenticationCodeManagerInterface
{
    public function generate(UserInterface $user);

    public function check(UserInterface $user, $code, $test = false);
}
