<?php

namespace MMC\User\Bundle\EmailBundle\DependencyInjection;

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
class MMCEmailExtension extends Extension implements PrependExtensionInterface
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

        //Mailer
        $container->setParameter('mmc_user.mailer.confirm.sender', $config['mailer']['confirm']['sender']);
        $container->setParameter('mmc_user.mailer.confirm.template', $config['mailer']['confirm']['template']);
        $container->setParameter('mmc_user.mailer.confirm.subject', $config['mailer']['confirm']['subject']);

        $container->setParameter('mmc_user.mailer.resetting.sender', $config['mailer']['resetting']['sender']);
        $container->setParameter('mmc_user.mailer.resetting.template', $config['mailer']['resetting']['template']);
        $container->setParameter('mmc_user.mailer.resetting.subject', $config['mailer']['resetting']['subject']);

        if ($config['mode'] == 'code') {
            $container->setParameter('mmc_user.mailer.email_form_code.sender', $config['mailer']['email_form_code']['sender']);
            $container->setParameter('mmc_user.mailer.email_form_code.template', $config['mailer']['email_form_code']['template']);
            $container->setParameter('mmc_user.mailer.email_form_code.subject', $config['mailer']['email_form_code']['subject']);
        } else {
            $container->setParameter('mmc_user.mailer.email_form_url.sender', $config['mailer']['email_form_url']['sender']);
            $container->setParameter('mmc_user.mailer.email_form_url.template', $config['mailer']['email_form_url']['template']);
            $container->setParameter('mmc_user.mailer.email_form_url.subject', $config['mailer']['email_form_url']['subject']);
        }
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
                    'email_form_route' => 'mmc_user.email_form.url',
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }
    }
}
