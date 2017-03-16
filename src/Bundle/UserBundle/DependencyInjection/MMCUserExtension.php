<?php

namespace MMC\User\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MMCUserExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        $container->setParameter('mmc_user.templates.layout', $config['templates']['layout']);
        $container->setParameter('mmc_user.main_firewall', $config['main_firewall']);
    }

    protected function addParameter($group, $key, $config, ContainerBuilder $container)
    {
        if (isset($config[$group][$key]) && $key != 'enabled') {
            $container->setParameter('mmc_user.'.$group.'.'.$key, $config[$group][$key]);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['TwigBundle'])
        ) {
            $twig_global = [
                'globals' => [
                    'mmc_user_layout' => $config['templates']['layout'],
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }

        //MMCLoginBundle
        if (isset($bundles['MMCLoginBundle'])
            && isset($bundles['TwigBundle'])
        ) {
            $twig_global = [
                'globals' => [
                    'login_form' => true,
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }

        //MMCResourceOwnersBundle
        if (isset($bundles['MMCResourceOwnersBundle'])
            && isset($bundles['TwigBundle'])
        ) {
            $twig_global = [
                'globals' => [
                    'resource_owners' => true,
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }

        //RememberMe
        if (isset($bundles['SecurityBundle'])
            && isset($bundles['TwigBundle'])
        ) {
            $securityConfig = $container->getExtensionConfig('security');

            foreach ($securityConfig as $key => $value) {
                if (isset($value['firewalls'][$config['main_firewall']]['remember_me'])) {
                    $twig_global = [
                        'globals' => [
                            'remember_me' => true,
                        ],
                    ];

                    $container->prependExtensionConfig('twig', $twig_global);
                }
            }
        }
    }
}
