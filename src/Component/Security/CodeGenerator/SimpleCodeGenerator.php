<?php

namespace MMC\User\Component\Security\CodeGenerator;

class SimpleCodeGenerator implements CodeGeneratorInterface
{
    public function generate()
    {
        $code = rand(100000, 999999);

        return $code;
    }
}
