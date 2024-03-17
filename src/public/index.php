<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use DS\Data\Converters\IConverter;
use DS\Data\Generators\AnyCollectionGenerator;
use DS\Data\Generators\AnyGenerator;
use DS\Data\Generators\IGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

try {
    $container = new ContainerBuilder();

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
    $loader->load('../config/services.yaml');

    /**
     * @var AnyCollectionGenerator<int, IGenerator> $stringCollectionGenerator
     */
    $stringCollectionGenerator = $container->get('string_collection_generator');

    /**
     * @var AnyGenerator<int, IConverter> $anyGenerator
     */
    $anyGenerator = $container->get('random_converters');

    foreach ($stringCollectionGenerator->getGenerator() as $value) {
        $oldValue = $newValue = $value;
        $converter = $anyGenerator->getValue();
        $converter->apply($newValue);

        echo sprintf('<b>(%s)</b><br/>Original: %s<br/>Converted: %s<br/><br/>', $converter::class, $oldValue, $newValue);
    }
} catch (Exception $e) {
    throw $e;
}