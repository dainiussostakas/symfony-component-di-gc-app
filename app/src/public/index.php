<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';

use DS\App\Factory\ContainerBuilderFactory;

try {
    $container = ContainerBuilderFactory::create();

    /**
     * @var \DS\App\Service\StringCollectionGeneratorService $stringCollectionGeneratorService
     */
    $stringCollectionGeneratorService = $container->get('string_collection_generator_service');

    $generator = $stringCollectionGeneratorService->generate();

    while ($generator->valid()) {
        /**
         * @var \DS\App\DTO\StringCollectionItemDTO $item
         */
        $item = $generator->current();

        echo sprintf(
            '<b>(%s)</b><br/>Original: %s<br/>Converted: %s<br/><br/>',
            $item->getConverter()::class,
            $item->getValue(),
            $item->getConvertedValue()
        );
        $generator->next();
    }
} catch (Exception $e) {
    throw $e;
}
