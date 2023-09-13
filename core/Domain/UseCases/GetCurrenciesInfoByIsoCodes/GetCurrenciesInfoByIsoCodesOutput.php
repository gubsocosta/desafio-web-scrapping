<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

use Core\Domain\Entities\CurrencyInfo;

class GetCurrenciesInfoByIsoCodesOutput
{
    /**
     * @param CurrencyInfo[] $currencyInfoList
     */
    public function __construct(
        public readonly array $currencyInfoList
    )
    {
    }
}
