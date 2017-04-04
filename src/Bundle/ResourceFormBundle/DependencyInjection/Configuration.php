<?php

namespace MMC\User\Bundle\ResourceFormBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mmc_resource_form');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addBaseConfiguration($rootNode);
        $this->addMailer($rootNode);

        return $treeBuilder;
    }

    protected function addBaseConfiguration($rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('modes')
                    ->isRequired()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->ignoreExtraKeys()
                        ->children()
                            ->scalarNode('type')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('sender')
                                ->defaultValue('mmc_user.resource_form.form.type')
                            ->end()
                            ->scalarNode('form_type')
                                ->defaultValue('mmc_user.resource_form.form.type')
                            ->end()
                            ->scalarNode('form_template')
                                ->defaultValue('no-reply@server.com')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
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
                        ->arrayNode('email_form_code')
                            ->addDefaultsIfNotSet()
                            ->children()
                              ->scalarNode('sender')
                                    ->defaultValue('no-reply@server.com')
                                ->end()
                                ->scalarNode('template')
                                    ->defaultValue('MMCEmailBundle:Security:email_code.html.twig')
                                ->end()
                                ->scalarNode('subject')
                                    ->defaultValue('email_form_code.subject.text')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('email_form_url')
                            ->addDefaultsIfNotSet()
                            ->children()
                              ->scalarNode('sender')
                                    ->defaultValue('no-reply@server.com')
                                ->end()
                                ->scalarNode('template')
                                    ->defaultValue('MMCEmailBundle:Security:email_url.html.twig')
                                ->end()
                                ->scalarNode('subject')
                                    ->defaultValue('email_form_url.subject.text')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
