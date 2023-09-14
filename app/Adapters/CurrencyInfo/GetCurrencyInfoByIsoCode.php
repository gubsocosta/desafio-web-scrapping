<?php

namespace App\Adapters\CurrencyInfo;

use Core\Domain\Entities\CurrencyInfo;

interface GetCurrencyInfoByIsoCode
{
    public function getCurrencyInfoByIsoCode(string $isoCode): CurrencyInfo | null;
}
