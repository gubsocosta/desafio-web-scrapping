<?php

namespace Tests\Unit\Core\Domain\UseCases\GetCurrenciesInfoByCodes;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use Core\Domain\UseCases\GetCurrenciesInfoByCodes\Gateways\GetCurrenciesInfoByCodesGateway;
use Core\Domain\UseCases\GetCurrenciesInfoByCodes\GetCurrenciesInfoByCodesInput;
use Core\Domain\UseCases\GetCurrenciesInfoByCodes\GetCurrenciesInfoByCodesUseCase;
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
        $mockedGateway = $this->createMock(GetCurrenciesInfoByCodesGateway::class);
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
        $useCase = new GetCurrenciesInfoByCodesUseCase($mockedLogger, $mockedGateway);
        $currencyInfo = $useCase->execute(new GetCurrenciesInfoByCodesInput(['GBP']))->currencyInfoList[0];
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
        $mockedGateway = $this->createMock(GetCurrenciesInfoByCodesGateway::class);
        $mockedGateway->expects($this->once())
            ->method('getCurrenciesInfoByCodeList')
            ->willThrowException(new \Exception('any error'));
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->once())
            ->method('error')
            ->with('Error when getting currencies information by codes: any error');
        $useCase = new GetCurrenciesInfoByCodesUseCase($mockedLogger, $mockedGateway);
        try {
            $useCase->execute(new GetCurrenciesInfoByCodesInput(['GBP']));
        } catch (\Exception $e) {
            $this->assertEquals('any error', $e->getMessage());
        }
    }
}
