<?php

namespace DS\App\Service;

use DS\App\DTO\StringCollectionItemDTO;
use DS\Data\Converters\IConverter;
use DS\Data\Generators\AnyCollectionGenerator;
use DS\Data\Generators\IGenerator;
use Generator;

class StringCollectionGeneratorService
{
    public function __construct(
        protected AnyCollectionGenerator $stringCollectionGenerator,
        protected IGenerator $randomConverterGenerator
    ) {
    }

    public function generate(): Generator
    {
        /**
         * @var IGenerator<string> $generator
         */
        foreach ($this->stringCollectionGenerator->getGenerator() as $generator) {
            $newValue = $oldValue = $generator->getValue();

            /**
             * @var IConverter<string> $converter
             */
            $converter = $this->randomConverterGenerator->getValue();
            $converter->apply($newValue);

            yield new StringCollectionItemDTO($converter, $oldValue, $newValue);
        }
    }
}
