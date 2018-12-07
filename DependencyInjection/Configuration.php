<?php

namespace KRG\MessageBundle\DependencyInjection;

use KRG\MessageBundle\Service\Helper\Esendex;
use KRG\MessageBundle\Service\Helper\Mailer;
use KRG\MessageBundle\Service\Sender;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
                                ->scalarNode('helper')->cannotBeEmpty()->defaultValue(Mailer::class)->end()
                                ->scalarNode('from')->isRequired()->cannotBeEmpty()->end()
                                ->arrayNode('bcc')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('esendex')
                            ->children()
                                ->scalarNode('helper')->cannotBeEmpty()->defaultValue(Esendex::class)->end()
                                ->scalarNode('account')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('login')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('from')->end()
                                ->arrayNode('bcc')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
