<?php

namespace LoremIpsum\PermissionCheckerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('lorem_ipsum_permission_checker');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('lorem_ipsum_permission_checker');
        }

        $rootNode
            ->children()
                ->arrayNode('roles')
                    ->isRequired()
                    ->children()
                        ->scalarNode('admin')->isRequired()->end()
                        ->scalarNode('super_admin')->isRequired()->end()
                    ->end()
                ->end()
                ->scalarNode('default_permission')->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
