<?php

namespace MMC\User\Component\Security\CodeGenerator;

use Ramsey\Uuid\Uuid;

class UuidCodeGenerator implements CodeGeneratorInterface
{
    public function generate()
    {
        $code = Uuid::uuid4();

        return $code;
    }
}
