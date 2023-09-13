<?php

namespace Tests\Unit\Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesInput;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\GetCurrenciesInfoByIsoCodesUseCase;
use Core\Infra\Log\Logger;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class GetCurrenciesInfoByCodesUseCaseTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testShouldGetCurrenciesInfoByCodes()
    {
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedGateway = $this->createMock(GetCurrenciesInfoByIsoCodesGateway::class);
        $mockedGateway->expects($this->once())
            ->method('getCurrenciesInfoByCodeList')
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
        $currencyInfo = $useCase->execute(new GetCurrenciesInfoByIsoCodesInput(['GBP']))->currencyInfoList[0];
        $currencyLocation = $currencyInfo->getLocationList()[0];
        $this->assertEquals('GBP', $currencyInfo->code);
        $this->assertEquals(826, $currencyInfo->number);
        $this->assertEquals(2, $currencyInfo->decimalPlaces);
        $this->assertEquals('Libra Esterlina', $currencyInfo->name);
        $this->assertEquals('Reino Unido', $currencyLocation->location);
        $this->assertEquals('https://example.com/usd-icon.png', $currencyLocation->icon);
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowAnExceptionWhenGatewayFails()
    {
        $mockedGateway = $this->createMock(GetCurrenciesInfoByIsoCodesGateway::class);
        $mockedGateway->expects($this->once())
            ->method('getCurrenciesInfoByCodeList')
            ->willThrowException(new \Exception('any error'));
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->once())
            ->method('error')
            ->with('Error when getting currencies information by codes: any error');
        $useCase = new GetCurrenciesInfoByIsoCodesUseCase($mockedLogger, $mockedGateway);
        try {
            $useCase->execute(new GetCurrenciesInfoByIsoCodesInput(['GBP']));
        } catch (\Exception $e) {
            $this->assertEquals('any error', $e->getMessage());
        }
    }
}
