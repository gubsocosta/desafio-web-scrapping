<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Rules;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;

class GetCurrenciesInfoByIsoCodesRule
{
    public function __construct(
        private readonly GetCurrenciesInfoByIsoCodesGateway $gateway
    )
    {
    }

    /**
     * @param string[] $isoCodeList
     * @return CurrencyInfo[]
     */
    public function handle(array $isoCodeList): array
    {
        return $this->gateway->getCurrenciesInfoByIsoCodeList($isoCodeList);
    }
}
