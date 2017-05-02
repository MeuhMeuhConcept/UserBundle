<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\DependencyInjection;

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
class MMCResourceOwnersExtension extends Extension implements PrependExtensionInterface
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

        $container->setParameter('mmc_user.resource_owners.class', $config['resource_owners_class']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $bundles = $container->getParameter('kernel.bundles');

        //ResourceOwners
        if (isset($bundles['HWIOAuthBundle'])
        ) {
            $hwiOAuthConfig = $container->getExtensionConfig('hwi_oauth');
            $resourceOwners = [];

            foreach ($hwiOAuthConfig as $key => $value) {
                foreach ($value['resource_owners'] as $keys) {
                    $resourceOwners[] = $keys['type'];
                }
            }

            $container->setParameter('mmc_ro.resource_owners', $resourceOwners);
        }
    }
}
