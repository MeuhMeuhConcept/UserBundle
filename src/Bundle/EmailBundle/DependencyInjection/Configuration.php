<?php

namespace MMC\User\Bundle\EmailBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mmc_email');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addMailer($rootNode);

        return $treeBuilder;
    }

    protected function addMailer($rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mailer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('confirm')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('sender')
                                    ->defaultValue('no-reply@server.com')
                                ->end()
                                ->scalarNode('template')
                                    ->defaultValue('MMCLoginBundle:Registration:email.html.twig')
                                ->end()
                                ->scalarNode('subject')
                                    ->defaultValue('Confirmation')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('resetting')
                            ->addDefaultsIfNotSet()
                            ->children()
                              ->scalarNode('sender')
                                    ->defaultValue('no-reply@server.com')
                                ->end()
                                ->scalarNode('template')
                                    ->defaultValue('MMCLoginBundle:Resetting:email.html.twig')
                                ->end()
                                ->scalarNode('subject')
                                    ->defaultValue('Resetting')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('email_form')
                            ->addDefaultsIfNotSet()
                            ->children()
                              ->scalarNode('sender')
                                    ->defaultValue('no-reply@server.com')
                                ->end()
                                ->scalarNode('template')
                                    ->defaultValue('MMCEmailBundle:Security:email_code.html.twig')
                                ->end()
                                ->scalarNode('subject')
                                    ->defaultValue('Login')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
