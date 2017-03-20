<?php

namespace MMC\User\Bundle\UserBundle;

use MMC\User\Bundle\UserBundle\DependencyInjection\Compiler\AuthenticatorBlockCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MMCUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AuthenticatorBlockCompilerPass());
    }
}
