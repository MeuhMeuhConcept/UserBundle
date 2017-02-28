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

        $rootNode
            ->children()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('layout')
                            ->defaultValue('MMCUserBundle::layout.html.twig')
                        ->end()
                        ->scalarNode('remember_me')
                            ->defaultValue(false)
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('mailer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('sender')
                            ->defaultValue('no-reply@server.com')
                        ->end()
                        ->scalarNode('template')
                            ->defaultValue('MMCUserBundle:Registration:email.html.twig')
                        ->end()
                        ->scalarNode('subject')
                            ->defaultValue('Confirmation')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
