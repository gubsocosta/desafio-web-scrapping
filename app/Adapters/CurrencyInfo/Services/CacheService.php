<?php

namespace App\Adapters\CurrencyInfo\Services;

use App\Adapters\CurrencyInfo\GetCurrencyInfoByIsoCode;
use Core\Domain\Entities\CurrencyInfo;
use Core\Infra\Caching\CacheClient;

class CacheService implements GetCurrencyInfoByIsoCode
{
    private int $expirationTimeInMinutes = 5;
    public function __construct(
        private readonly CacheClient $cacheClient
    )
    {
    }

    public function getCurrencyInfoByIsoCode(string $isoCode): CurrencyInfo | null
    {
        if(!$this->hasCurrencyInfo($isoCode)) {
            return null;
        }

        return $this->cacheClient->get($isoCode);
    }
    public function putCurrencyInfo(string $isoCode, CurrencyInfo $currencyInfo): void
    {
        $this->cacheClient->put($isoCode, $currencyInfo, $this->expirationTimeInMinutes);
    }

    private function hasCurrencyInfo(string $isoCode): bool
    {
        return $this->cacheClient->has($isoCode);
    }
}
