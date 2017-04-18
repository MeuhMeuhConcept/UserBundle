<?php

namespace MMC\User\Bundle\LoginFormBundle\DependencyInjection;

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
class MMCLoginFormExtension extends Extension implements PrependExtensionInterface
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

        $container->setParameter('mmc_login.registration.condition', $config['registration']);
        $container->setParameter('mmc_login.forgot_password', $config['forgot_password']);
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
                    'registration' => $config['registration'],
                    'forgot_password' => $config['forgot_password'],
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }
    }
}
