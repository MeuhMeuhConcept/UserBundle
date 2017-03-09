<?php

namespace MMC\User\Bundle\LoginBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mmc_login');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addBaseConfiguration($rootNode);

        return $treeBuilder;
    }

    protected function addBaseConfiguration($rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('registration')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('forgot_password')
                    ->defaultValue(false)
                ->end()
            ->end()
        ;
    }
}
