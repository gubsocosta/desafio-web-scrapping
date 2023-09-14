<?php

namespace Tests\Unit\App\Adapters\CurrencyInfo;

use App\Adapters\CurrencyInfo\Exceptions\CurrencyInfoNotFoundException;
use App\Adapters\CurrencyInfo\GetCurrenciesInfoByIsoCodesAdapter;
use App\Adapters\CurrencyInfo\Services\CacheService;
use App\Adapters\CurrencyInfo\Services\CrawlerService;
use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use Exception;
use PHPUnit\Framework\MockObject\Exception as PHPUnitException;
use PHPUnit\Framework\TestCase;

class GetCurrenciesInfoByIsoCodesAdapterTest extends TestCase
{
    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldGetCurrenciesInfoByIsoCodes()
    {
        $cacheService = $this->createMock(CacheService::class);
        $cacheService->expects($this->exactly(2))
            ->method('getCurrencyInfoByIsoCode')
            ->willReturnOnConsecutiveCalls(
                new CurrencyInfo(
                    'GBP',
                    826,
                    2,
                    'Libra Esterlina',
                    [
                        new  CurrencyLocation('Reino Unido', 'https://example.com/usd-icon.png')
                    ]
                ),
                null
            );
        $cacheService->expects($this->once())->method('putCurrencyInfo');
        $crawlerService = $this->createMock(CrawlerService::class);
        $crawlerService->expects($this->once())
            ->method('getCurrencyInfoByIsoCode')
            ->willReturn(new CurrencyInfo('BRL',
                986,
                2,
                'REAL',
                [
                    new  CurrencyLocation('Brasil', 'https://example.com/brazil-icon.png')
                ]));
        $adapter = new GetCurrenciesInfoByIsoCodesAdapter($cacheService, $crawlerService);
        $isoCodeList = ['GBP', 'BRL'];
        $result = $adapter->getCurrenciesInfoByIsoCodeList($isoCodeList);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(CurrencyInfo::class, $result[0]);
        $this->assertInstanceOf(CurrencyInfo::class, $result[1]);
    }

    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldThrowAnExceptionWhenNotFindCurrencyInfos()
    {
        $cacheService = $this->createMock(CacheService::class);
        $cacheService->expects($this->once())
            ->method('getCurrencyInfoByIsoCode')
            ->willReturn(null);
        $crawlerService = $this->createMock(CrawlerService::class);
        $crawlerService->expects($this->once())
            ->method('getCurrencyInfoByIsoCode')
            ->willReturn(null);
        $adapter = new GetCurrenciesInfoByIsoCodesAdapter($cacheService, $crawlerService);
        $isoCodeList = ['XYZ'];
        $this->expectException(CurrencyInfoNotFoundException::class);
        $adapter->getCurrenciesInfoByIsoCodeList($isoCodeList);
    }
}
