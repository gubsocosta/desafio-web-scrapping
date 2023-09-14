<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Rules;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\CurrencyInfoOutput;

class MapCurrenciesInfoToOutputRule
{
    /**
     * @param CurrencyInfo[] $currencyInfoList
     * @return CurrencyInfoOutput[]
     */
    public function handle(array $currencyInfoList): array {
        return array_map(function (CurrencyInfo $currencyInfo) {
            return new CurrencyInfoOutput(
                $currencyInfo->isoCode,
                $currencyInfo->numericCode,
                $currencyInfo->decimalPlaces,
                $currencyInfo->name,
                $currencyInfo->getLocationList()
            );
        }, $currencyInfoList);
    }
}
