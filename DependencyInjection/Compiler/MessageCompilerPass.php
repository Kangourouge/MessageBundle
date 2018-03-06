<?php

namespace KRG\MessageBundle\DependencyInjection\Compiler;

use KRG\MessageBundle\Service\Registry\MessageRegistry;
use KRG\MessageBundle\Service\Registry\SenderRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MessageCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Add only configurated senders
        $senderRegistryDefinition = $container->getDefinition(SenderRegistry::class);
        foreach ($container->findTaggedServiceIds('message.sender') as $id => $config) {
            $senderRegistryDefinition->addMethodCall('addSender', [new Reference($id), $id]);
        }

        // Add messages
        $messageRegistryDefinition = $container->getDefinition(MessageRegistry::class);
        foreach ($container->findTaggedServiceIds('message.type') as $id => $config) {
            $messageRegistryDefinition->addMethodCall('addMessage', [new Reference($id), $id]);
        }
    }
}
