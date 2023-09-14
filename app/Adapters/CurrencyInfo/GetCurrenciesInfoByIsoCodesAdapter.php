<?php

namespace App\Adapters\CurrencyInfo;

use App\Adapters\CurrencyInfo\Exceptions\CurrencyInfoNotFoundException;
use App\Adapters\CurrencyInfo\Services\CacheService;
use App\Adapters\CurrencyInfo\Services\CrawlerService;
use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Exception;

final class GetCurrenciesInfoByIsoCodesAdapter implements GetCurrenciesInfoByIsoCodesGateway
{
    public function __construct(
        private readonly CacheService   $cacheService,
        private readonly CrawlerService $crawlerService
    )
    {
    }

    /**
     * @param string[] $isoCodeList
     * @return CurrencyInfo[]
     * @throws Exception
     */
    public function getCurrenciesInfoByIsoCodeList(array $isoCodeList): array
    {
        $isoCodeList = array_unique($isoCodeList);
        return array_map(function (string $isoCode) {
            return $this->getCurrencyInfoByIsoCode($isoCode);
        }, $isoCodeList);
    }

    /**
     * @param string $isoCode
     * @return CurrencyInfo
     * @throws Exception
     */
    private function getCurrencyInfoByIsoCode(string $isoCode): CurrencyInfo
    {
        $isoCode =  strtoupper($isoCode);
        $currencyInfoByCache = $this->cacheService->getCurrencyInfoByIsoCode($isoCode);
        if ($currencyInfoByCache) {
            return $currencyInfoByCache;
        }
        $currencyInfoByCrawler = $this->crawlerService->getCurrencyInfoByIsoCode($isoCode);
        if (!$currencyInfoByCrawler) {
            throw new CurrencyInfoNotFoundException($isoCode);
        }
        $this->cacheService->putCurrencyInfo($isoCode, $currencyInfoByCrawler);
        return $currencyInfoByCrawler;
    }
}
