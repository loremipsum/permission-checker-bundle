<?php

namespace LoremIpsum\PermissionCheckerBundle\DependencyInjection;

use LoremIpsum\PermissionCheckerBundle\Utils\PermissionChecker;
use LoremIpsum\PermissionCheckerBundle\Twig\PermissionExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LoremIpsumPermissionCheckerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(PermissionChecker::class);
        $definition->setArgument('$roles', $config['roles']);

        $definition = $container->getDefinition(PermissionExtension::class);
        $definition->setArgument('$actionPermission', $config['default_permission'] ?? null);
    }
}
