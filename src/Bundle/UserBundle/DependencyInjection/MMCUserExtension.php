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
        $container->setParameter('mmc_user.templates.remember_me', $config['templates']['remember_me']);

        //Mailer
        $container->setParameter('mmc_user.mailer.confirm.sender', $config['mailer']['confirm']['sender']);
        $container->setParameter('mmc_user.mailer.confirm.template', $config['mailer']['confirm']['template']);
        $container->setParameter('mmc_user.mailer.confirm.subject', $config['mailer']['confirm']['subject']);

        $container->setParameter('mmc_user.mailer.resetting.sender', $config['mailer']['resetting']['sender']);
        $container->setParameter('mmc_user.mailer.resetting.template', $config['mailer']['resetting']['template']);
        $container->setParameter('mmc_user.mailer.resetting.subject', $config['mailer']['resetting']['subject']);


        $container->setParameter('mmc_user.registration.condition', $config['registration']);

        //Carousels
        foreach ($config['login_form'] as $name => $value) {
            $this->addParameter('login_form', $name, $config, $container);
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

        //var_dump($container->getExtensionConfig('security'));die;

        if (isset($bundles['TwigBundle'])
        ) {
            $twig_global = [
                'globals' => [
                    'mmc_user_layout' => $config['templates']['layout'],
                    'remember_me' => $config['templates']['remember_me'],
                    'registration' => $config['registration'],
                    'forgot_password' => $config['login_form']['forgot_password'],
                ],
            ];

            $container->prependExtensionConfig('twig', $twig_global);
        }
    }
}
