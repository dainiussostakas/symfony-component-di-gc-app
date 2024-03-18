<?php

namespace DS\App\DTO;

use DS\Data\Converters\IConverter;

class StringCollectionItemDTO
{
    public function __construct(
        protected IConverter $converter,
        protected string $value,
        protected string $convertedValue
    ) {
    }

    public function getConverter(): IConverter
    {
        return $this->converter;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getConvertedValue(): string
    {
        return $this->convertedValue;
    }
}
