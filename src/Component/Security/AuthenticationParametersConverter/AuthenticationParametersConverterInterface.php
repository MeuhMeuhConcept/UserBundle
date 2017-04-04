<?php

namespace MMC\User\Component\Security\AuthenticationParametersConverter;

interface AuthenticationParametersConverterInterface
{
    public function convert($user, $code);

    public function revert($param);
}
