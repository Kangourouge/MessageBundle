<?php

namespace KRG\MessageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

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

        foreach ($config['senders'] as $name => $sender) {

            $helper = null;
            if (class_exists($sender['helper'])) {
                $helper = new $sender['helper'];
            } else {
                if ($sender['helper'] === 'krg.message.helper.mailer') {
                    $loader->load('mailer.yml');
                }

                if ($sender['helper'] === 'krg.message.helper.esendex') {
                    $loader->load('esendex.yml');
                    $container->setParameter('krg_message_esendex_account', $sender['account']);
                    $container->setParameter('krg_message_esendex_login', $sender['login']);
                    $container->setParameter('krg_message_esendex_password', $sender['password']);
                }

                $helper = new Reference($sender['helper']);
            }

            $container
                ->register('krg.message.sender.'.$name, $config['class'])
                ->addArgument($helper)
                ->addArgument(isset($sender['from']) ? $sender['from'] : null)
                ->addArgument(isset($sender['bcc']) ? $sender['bcc'] : array())
                ->addTag('message.sender', array('alias' => $name))
                ;
        }
    }
}
