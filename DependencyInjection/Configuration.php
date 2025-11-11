<?php

namespace LoremIpsum\PermissionCheckerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $name        = 'lorem_ipsum_permission_checker';
        $treeBuilder = new TreeBuilder($name);
        $this->getRootNode($treeBuilder, $name)
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

    /**
     * @param TreeBuilder $treeBuilder
     * @param string      $name
     * @return ArrayNodeDefinition|NodeDefinition
     */
    private function getRootNode(TreeBuilder $treeBuilder, string $name)
    {
        if (method_exists($treeBuilder, 'getRootNode')) {
            return $treeBuilder->getRootNode();
        }
        // BC layer for symfony/config 4.1 and older
        return $treeBuilder->root($name);
    }
}
