<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByCodes\Gateways;

use Core\Domain\Entities\CurrencyInfo;

interface GetCurrenciesInfoByCodesGateway
{
    /**
     * @param array<int> $codeList
     * @return array<CurrencyInfo>
     */
    public function getCurrenciesInfoByCodeList(array $codeList): array;
}
