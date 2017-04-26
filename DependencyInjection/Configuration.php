<?php

namespace KRG\MessageBundle\DependencyInjection;

use KRG\MessageBundle\Sender\Helper\Mailer;
use KRG\MessageBundle\Sender\Helper\Sms;
use KRG\MessageBundle\Sender\Sender;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('krg_message');

        $rootNode
            ->children()
                ->scalarNode('class')->cannotBeEmpty()->defaultValue(Sender::class)->end()
                ->arrayNode('senders')
                    ->children()
                        ->arrayNode('mailer')
                            ->children()
                                ->scalarNode('helper')->cannotBeEmpty()->defaultValue('krg.message.helper.mailer')->end()
                                ->scalarNode('from')->end()
                                ->arrayNode('bcc')->end()
                            ->end()
                        ->end()
                        ->arrayNode('esendex')
                            ->children()
                                ->scalarNode('helper')->cannotBeEmpty()->defaultValue('krg.message.helper.esendex')->end()
                                ->scalarNode('account')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('login')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('from')->end()
                                ->arrayNode('bcc')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
