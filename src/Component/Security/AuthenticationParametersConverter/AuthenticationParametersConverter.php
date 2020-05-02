<?php

namespace MMC\User\Component\Security\AuthenticationParametersConverter;

class AuthenticationParametersConverter implements AuthenticationParametersConverterInterface
{
    public function convert($user, $code)
    {
        $code = base64_encode($user.'|'.$code);

        return $code;
    }

    public function revert($token)
    {
        $param = [];

        $tab = explode('|', base64_decode($token));

        $param['user'] = $tab[0];
        $param['code'] = $tab[1];

        return $param;
    }
}
