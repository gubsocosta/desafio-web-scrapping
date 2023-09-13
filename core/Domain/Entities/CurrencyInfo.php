<?php

namespace Core\Domain\Entities;

final class CurrencyInfo
{
    public function __construct(
        public readonly string $code,
        public readonly int    $number,
        public readonly float  $decimalPlaces,
        public readonly string $name,
        private array          $locationList = []
    )
    {
    }

    /**
     * @param CurrencyLocation $location
     * @return void
     */
    public function addLocation(CurrencyLocation $location): void
    {
        $this->locationList[] = $location;
    }

    /**
     * @return CurrencyLocation[]
     */
    public function getLocationList(): array
    {
        return $this->locationList;
    }
}
