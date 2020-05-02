<?php

namespace MMC\User\Bundle\ResourceFormBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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

        $container->setParameter('mmc_user.resource_form.class', $config['resource_form_class']);

        $blockDefinition = $container->getDefinition('mmc_user.email.authenticator_block');
        $controllerCodeDefinition = $container->getDefinition('mmc_user.resource_form.controller');
        $renderDefinition = $container->getDefinition('mmc_user.resource_form.controller.render');
        $registrationBlockDefinition = $container->getDefinition('mmc_user.resource_form.registration_block');
        $registrationControllerDefinition = $container->getDefinition('mmc_user.resource_form.controller.registration');

        foreach ($config['modes'] as $name => $options) {
            foreach ($options as $key => $value) {
                // Mode pour le controller
                $parameters = [
                    $name,
                    $options['type'],
                    $options['form_type'],
                    $options['message_subject'],
                    $options['message_template'],
                    $options['block_template'],
                ];

                $def = new Definition('MMC\User\Component\ResourceForm\Mode\ModeController', $parameters);

                $mode = $container->setDefinition('mmc_user.resource_form.mode_controller.'.$key, $def);

                $controllerCodeDefinition->addMethodCall('addMode', [$mode]);

                //Mode pour le block
                $parameters = [
                    $name,
                    $options['type'],
                    $options['form_type'],
                    $options['block_template'],
                ];

                $def = new Definition('MMC\User\Component\ResourceForm\Mode\ModeBlock', $parameters);

                $mode = $container->setDefinition('mmc_user.resource_form.mode_block.'.$key, $def);

                $blockDefinition->addMethodCall('addMode', [$mode]);

                //Mode pour le render
                $parameters = [
                    $name,
                    $options['type'],
                    $options['render_template'],
                ];

                $def = new Definition('MMC\User\Component\ResourceForm\Mode\ModeRender', $parameters);

                $mode = $container->setDefinition('mmc_user.resource_form.mode_render.'.$key, $def);

                $renderDefinition->addMethodCall('addMode', [$mode]);

                //Mode pour la registration
                $parameters = [
                    $name,
                    $options['type'],
                    $options['form_type'],
                    $options['registration_template'],
                ];

                $def = new Definition('MMC\User\Component\ResourceForm\Mode\ModeRegistration', $parameters);

                $mode = $container->setDefinition('mmc_user.resource_form.mode_registration.'.$key, $def);

                $registrationBlockDefinition->addMethodCall('addMode', [$mode]);
                $registrationControllerDefinition->addMethodCall('addMode', [$mode]);
            }
        }

        // Création des routes en dynamique
        //route_name, param_route

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
