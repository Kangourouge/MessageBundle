<?php

namespace KRG\MessageBundle\DependencyInjection;

use KRG\MessageBundle\Service\Helper\Esendex;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
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
            if ($sender['helper'] === Esendex::class) {
                $container->setParameter('krg_message_esendex_account', $sender['account']);
                $container->setParameter('krg_message_esendex_login', $sender['login']);
                $container->setParameter('krg_message_esendex_password', $sender['password']);
                $container->setParameter('krg_message_esendex_from', $sender['from']);
            }

            // Create Sender services with different Helper (Mailer, Esendex, ...) based on config
            $container
                ->register(SenderRegistry::SENDER_PREFIX.$name, $config['class'])
                ->addArgument(new Reference($sender['helper']))
                ->addArgument(isset($sender['from']) ? $sender['from'] : null)
                ->addArgument(isset($sender['bcc']) ? $sender['bcc'] : array())
                ->addTag('message.sender', array('alias' => $name))
                ->setAutowired(true)
                ->setAutoconfigured(true);
        }
    }
}
