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

        $this->configQueue($rootNode);
        $this->configDatabase($rootNode);
        $this->configCache($rootNode);

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

                ->arrayNode('failed')->children()
                    ->scalarNode('database')->end()
                    ->scalarNode('table')->end()
                ->end()->end()

                ->arrayNode('connections')->children()
                    ->arrayNode('sync')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('table')->end()
                        ->scalarNode('queue')->end()
                        ->integerNode('retry_after')->end()
                    ->end()->end()

                    ->arrayNode('database')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('table')->end()
                        ->scalarNode('queue')->end()
                        ->integerNode('retry_after')->end()
                    ->end()->end()

                    ->arrayNode('beanstalkd')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('host')->end()
                        ->scalarNode('queue')->end()
                        ->integerNode('retry_after')->end()
                    ->end()->end()

                    ->arrayNode('sqs')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('key')->end()
                        ->scalarNode('secret')->end()
                        ->scalarNode('prefix')->end()
                        ->scalarNode('queue')->end()
                        ->scalarNode('region')->end()
                    ->end()->end()

                    ->arrayNode('redis')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('connection')->end()
                        ->scalarNode('queue')->end()
                        ->integerNode('retry_after')->end()
                    ->end()->end()
                ->end()->end()
            ->end()->end();
    }

    protected function configDatabase(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('database')->children()
                ->scalarNode('default')->end()

                ->arrayNode('connections')->children()
                    ->arrayNode('mysql')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('host')->end()
                        ->scalarNode('port')->end()
                        ->scalarNode('database')->end()
                        ->scalarNode('username')->end()
                        ->scalarNode('password')->end()
                        ->scalarNode('unix_socket')->end()
                        ->scalarNode('charset')->end()
                        ->scalarNode('collation')->end()
                        ->scalarNode('prefix')->end()
                        ->scalarNode('strict')->end()
                        ->booleanNode('strict')->end()
                        ->scalarNode('engine')->end()
                    ->end()->end()
                ->end()->end()

                ->arrayNode('redis')->children()
                    ->scalarNode('client')->end()
                    ->arrayNode('default')->children()
                        ->scalarNode('host')->end()
                        ->scalarNode('password')->end()
                        ->integerNode('port')->end()
                        ->integerNode('database')->end()
                    ->end()->end()
                ->end()->end()
            ->end()->end();
    }

    protected function configCache(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('cache')->children()
                ->scalarNode('default')->end()
                ->scalarNode('prefix')->end()
                ->arrayNode('stores')->children()
                    ->arrayNode('apc')->children()
                        ->scalarNode('driver')->end()
                    ->end()->end()

                    ->arrayNode('array')->children()
                        ->scalarNode('driver')->end()
                    ->end()->end()

                    ->arrayNode('database')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('table')->end()
                        ->scalarNode('connection')->end()
                    ->end()->end()

                    ->arrayNode('file')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('file')->end()
                        ->scalarNode('path')->end()
                    ->end()->end()

                    ->arrayNode('memcached')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('persistent_id')->end()
                        ->arrayNode('sasl')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('servers')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('host')->end()
                                    ->scalarNode('port')->end()
                                    ->scalarNode('weight')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()->end()

                    ->arrayNode('redis')->children()
                        ->scalarNode('driver')->end()
                        ->scalarNode('connection')->end()
                    ->end()->end()
                ->end()->end()
            ->end()->end();
    }
}
