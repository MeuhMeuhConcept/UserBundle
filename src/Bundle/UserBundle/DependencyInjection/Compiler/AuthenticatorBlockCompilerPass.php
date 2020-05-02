<?php

namespace MMC\User\Bundle\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AuthenticatorBlockCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('mmc_user.chain.authenticator_block');
        $taggedServices = $container->findTaggedServiceIds('mmc_user.chain.authenticator_block');
        foreach ($taggedServices as $id => $properties) {
            $definition->addMethodCall(
                'addAuthenticatorBlocks',
                [new Reference($id)]
            );
        }
    }
}
