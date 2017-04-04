<?php

namespace MMC\User\Component\Mailer;

interface CodeSender
{
    public function sendCode($user, $code);
}
