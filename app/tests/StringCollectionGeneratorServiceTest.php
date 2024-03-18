<?php

namespace DS\App\Tests;

use DS\App\DTO\StringCollectionItemDTO;
use DS\App\Factory\ContainerBuilderFactory;
use DS\App\Service\StringCollectionGeneratorService;
use DS\Data\Converters\AlphaToNumberConverter;
use DS\Data\Converters\IConverter;
use DS\Data\Converters\StringRot13Converter;
use Exception;
use PHPUnit\Framework\TestCase;

class StringCollectionGeneratorServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGeneration()
    {
        $containerBuilder = ContainerBuilderFactory::create();

        /**
         * @var StringCollectionGeneratorService $stringCollectionGeneratorFactory
         */
        $stringCollectionGeneratorFactory = $containerBuilder->get('string_collection_generator_service');
        $stringLength = $containerBuilder->getParameter('string_generator_length');
        $itemCount = $containerBuilder->getParameter('string_generator_collection_count');

        $generator = $stringCollectionGeneratorFactory->generate();

        $items = [];

        while ($generator->valid()) {
            /**
             * @var StringCollectionItemDTO $item
             */
            $item = $generator->current();
            $items[] = $item;
            $converter = $item->getConverter();

            $this->assertInstanceOf(IConverter::class, $converter);
            $this->assertContains($converter::class, [AlphaToNumberConverter::class, StringRot13Converter::class]);

            if ($converter instanceof AlphaToNumberConverter) {
                $this->assertMatchesRegularExpression("/^.+(\/.+)*$/u", $item->getConvertedValue());
            } elseif ($converter instanceof StringRot13Converter) {
                $this->assertMatchesRegularExpression(
                    "/^[0-9A-Za-z]{{$stringLength}}$/u",
                    $item->getConvertedValue()
                );
            }

            $generator->next();
        }

        $this->assertCount($itemCount, $items);
    }
}
