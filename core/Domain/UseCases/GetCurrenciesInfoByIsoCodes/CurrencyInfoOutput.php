<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

class CurrencyInfoOutput
{
    public function __construct(
        public readonly string $isoCode,
        public readonly int    $numericCode,
        public readonly float  $decimalPlaces,
        public readonly string $name,
        public readonly array  $locationList
    )
    {
    }
}
