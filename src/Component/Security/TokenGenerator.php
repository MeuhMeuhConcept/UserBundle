<?php

namespace MMC\User\Component\Security;

use Ramsey\Uuid\Uuid;

class TokenGenerator
{
    public function generateUuidToken()
    {
        return Uuid::uuid4();
    }
}
