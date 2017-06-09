<?php

namespace Lneicelis\QueueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('lneicelis_queue');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }

    protected function configQueue(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('queue')->children()
                ->scalarNode('default')->end()

                ->arrayNode('connections')
                    ->children()
                        ->arrayNode('sync')
                            ->children()
                                ->scalarNode('driver')->end()
                                ->scalarNode('table')->end()
                                ->scalarNode('queue')->end()
                                ->integerNode('retry_after')->end()
                            ->end()
                        ->end()

                        ->arrayNode('database')
                            ->children()
                                ->scalarNode('driver')->end()
                                ->scalarNode('table')->end()
                                ->scalarNode('queue')->end()
                                ->integerNode('retry_after')->end()
                            ->end()
                        ->end()

                        ->arrayNode('beanstalkd')
                            ->children()
                                ->scalarNode('driver')->end()
                                ->scalarNode('host')->end()
                                ->scalarNode('queue')->end()
                                ->integerNode('retry_after')->end()
                            ->end()
                        ->end()

                        ->arrayNode('sqs')
                            ->children()
                                ->scalarNode('driver')->end()
                                ->scalarNode('key')->end()
                                ->scalarNode('secret')->end()
                                ->scalarNode('prefix')->end()
                                ->scalarNode('queue')->end()
                                ->integerNode('retry_after')->end()
                            ->end()
                        ->end()

                        ->arrayNode('sqs')
                            ->children()
                                ->scalarNode('driver')->end()
                                ->scalarNode('connection')->end()
                                ->scalarNode('queue')->end()
                                ->integerNode('retry_after')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('failed')
                    ->children()
                        ->scalarNode('database')->end()
                        ->scalarNode('table')->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
