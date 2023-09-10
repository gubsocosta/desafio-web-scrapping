<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByCodes;

use Core\Domain\Entities\CurrencyInfo;

class GetCurrenciesInfoByCodesOutput
{
    /**
     * @param array<CurrencyInfo> $currencyInfoList
     */
    public function __construct(
        public readonly array $currencyInfoList
    )
    {
    }
}
