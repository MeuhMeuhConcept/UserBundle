<?php

namespace MMC\User\Component\Mailer;

interface CodeSenderInterface
{
    public function sendCode($user, $code);
}
