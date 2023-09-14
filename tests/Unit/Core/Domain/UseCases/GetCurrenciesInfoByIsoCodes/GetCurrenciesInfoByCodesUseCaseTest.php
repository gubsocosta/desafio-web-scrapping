<?php

namespace Tests\Unit\Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesInput;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesUseCase;
use Core\Infra\Log\Logger;
use Exception;
use PHPUnit\Framework\MockObject\Exception as PHPUnitException;
use PHPUnit\Framework\TestCase;

class GetCurrenciesInfoByCodesUseCaseTest extends TestCase
{
    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldGetCurrenciesInfoByCodes()
    {
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedGateway = $this->createMock(GetCurrenciesInfoByIsoCodesGateway::class);
        $mockedGateway->expects($this->once())
            ->method('getCurrenciesInfoByIsoCodeList')
            ->willReturn([
                new CurrencyInfo(
                    'GBP',
                    826,
                    2,
                    'Libra Esterlina',
                    [
                        new  CurrencyLocation('Reino Unido', 'https://example.com/usd-icon.png')
                    ]
                )
            ]);
        $useCase = new GetCurrenciesInfoByIsoCodesUseCase($mockedLogger, $mockedGateway);
        $result = $useCase->execute(new GetCurrenciesInfoByIsoCodesInput(['GBP']));
        $currencyInfoList = $result->currencyInfoList;
        $this->assertCount(1, $currencyInfoList);
        $currencyInfo = $currencyInfoList[0];
        $this->assertCount(1, $currencyInfo->locationList);
        $this->assertEquals('GBP', $currencyInfo->isoCode);
        $this->assertEquals(826, $currencyInfo->numericCode);
        $this->assertEquals(2, $currencyInfo->decimalPlaces);
        $this->assertEquals('Libra Esterlina', $currencyInfo->name);
        $currencyLocation = $currencyInfo->locationList[0];
        $this->assertEquals('Reino Unido', $currencyLocation->location);
        $this->assertEquals('https://example.com/usd-icon.png', $currencyLocation->flagIconUrl);
    }

    /**
     * @throws PHPUnitException
     */
    public function testShouldThrowAnExceptionWhenGatewayFails()
    {
        $mockedGateway = $this->createMock(GetCurrenciesInfoByIsoCodesGateway::class);
        $mockedGateway->expects($this->once())
            ->method('getCurrenciesInfoByIsoCodeList')
            ->willThrowException(new Exception('any error'));
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->once())
            ->method('error')
            ->with('Error when getting currencies information by iso codes: any error');
        $useCase = new GetCurrenciesInfoByIsoCodesUseCase($mockedLogger, $mockedGateway);
        try {
            $useCase->execute(new GetCurrenciesInfoByIsoCodesInput(['GBP']));
        } catch (Exception $e) {
            $this->assertEquals('any error', $e->getMessage());
        }
    }
}
