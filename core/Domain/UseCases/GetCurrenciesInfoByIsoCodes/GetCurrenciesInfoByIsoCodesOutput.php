<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

class GetCurrenciesInfoByIsoCodesOutput
{
    /**
     * @param CurrencyInfoOutput[] $currencyInfoList
     */
    public function __construct(
        public readonly array $currencyInfoList
    )
    {
    }
}
