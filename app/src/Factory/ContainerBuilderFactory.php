<?php

namespace DS\App\Factory;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerBuilderFactory
{
    /**
     * @throws Exception
     */
    public static function create(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('../config/services.yaml');

        return $container;
    }
}
