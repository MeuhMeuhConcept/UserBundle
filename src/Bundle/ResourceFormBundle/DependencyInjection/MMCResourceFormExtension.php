<?php

namespace MMC\User\Bundle\ResourceFormBundle\DependencyInjection;

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
class MMCResourceFormExtension extends Extension implements PrependExtensionInterface
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

        foreach ($config['modes'] as $options => $option) {
            foreach ($option as $key => $value) {
                $container->setParameter('mmc_user.resource_form.'.$key, $config['modes'][$options][$key]);
            }
        }

        //Mailer
        $container->setParameter('mmc_user.mailer.resource_form.sender', $config['mailer']['email_form_code']['sender']);
        $container->setParameter('mmc_user.mailer.resource_form.template', $config['mailer']['email_form_code']['template']);
        $container->setParameter('mmc_user.mailer.resource_form.subject', $config['mailer']['email_form_code']['subject']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $bundles = $container->getParameter('kernel.bundles');

        //ResourceForms
        $ResourceFormConfig = $container->getExtensionConfig('mmc_resource_form');
        $resourceForms = [];

        foreach ($ResourceFormConfig as $options => $option) {
            foreach ($option['modes'] as $key => $value) {
                $resourceForms[] = $value['type'];
            }
        }

        $container->setParameter('mmc_resource_form.resource_forms', $resourceForms);
    }
}
