<?php

namespace MMC\User\Bundle\UserBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mmc_user');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addTemplate($rootNode);
        $this->addBaseConfiguration($rootNode);

        return $treeBuilder;
    }

    protected function addTemplate($rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('layout')
                            ->defaultValue('MMCUserBundle::layout.html.twig')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    protected function addBaseConfiguration($rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('main_firewall')
                    ->defaultValue('main')
                ->end()
                ->scalarNode('registration')
                   ->defaultValue(true)
                ->end()
            ->end()
        ;
    }
}
