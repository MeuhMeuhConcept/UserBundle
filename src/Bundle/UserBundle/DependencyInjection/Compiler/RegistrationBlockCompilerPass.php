<?php

namespace MMC\User\Bundle\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegistrationBlockCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('mmc_user.chain.registration_block');
        $taggedServices = $container->findTaggedServiceIds('mmc_user.chain.registration_block');
        foreach ($taggedServices as $id => $properties) {
            $definition->addMethodCall(
                'addRegistrationBlocks',
                [new Reference($id)]
            );
        }
    }
}
