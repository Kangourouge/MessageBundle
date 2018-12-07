<?php

namespace KRG\MessageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class KRGMessageExtension extends Extension
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

        foreach ($config['senders'] as $name => $_config) {
            foreach ($_config as $key => $value) {
                $container->setParameter(sprintf('krg_message_%s_%s', $name, $key), $value);
            }

            // Create Sender services with different Helper (Mailer, Esendex, ...) based on config
            $container
                ->register(sprintf('krg.message.%s', $name), $config['class'])
                ->addTag('message.sender', ['alias' => $name])
                ->setArgument(0, new Reference($_config['helper']))
                ->setAutoconfigured(true)
                ->setAutowired(true);
        }
    }
}
