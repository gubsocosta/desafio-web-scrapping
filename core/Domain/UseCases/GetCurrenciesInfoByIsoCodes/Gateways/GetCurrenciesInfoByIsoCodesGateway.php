<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways;

use Core\Domain\Entities\CurrencyInfo;

interface GetCurrenciesInfoByIsoCodesGateway
{
    /**
     * @param array<int> $isoCodeList
     * @return array<CurrencyInfo>
     */
    public function getCurrenciesInfoByCodeList(array $isoCodeList): array;
}
