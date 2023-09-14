<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use PHPUnit\Framework\TestCase;

class CurrencyInfoTest extends TestCase
{

    public function testShouldCreateCurrencyInfo()
    {
        $isoCode = 'GBP';
        $numericCode = 826;
        $decimalPlaces = 2;
        $currencyName = 'Libra Esterlina';
        $currencyInfo = new CurrencyInfo($isoCode, $numericCode, $decimalPlaces, $currencyName);
        $this->assertInstanceOf(CurrencyInfo::class, $currencyInfo);
        $this->assertEquals($isoCode, $currencyInfo->isoCode);
        $this->assertEquals($numericCode, $currencyInfo->numericCode);
        $this->assertEquals($decimalPlaces, $currencyInfo->decimalPlaces);
        $this->assertEquals($currencyName, $currencyInfo->name);
    }

    public function testShouldAddLocation()
    {
        $currencyInfo = new CurrencyInfo('GBP', 826, 2, 'Libra Esterlina');
        $location = 'Reino Unido';
        $flagIconUrl = 'https://example.com/uk-icon.png';
        $currencyInfo->addLocation(new CurrencyLocation($location, $flagIconUrl));
        $this->assertCount(1, $currencyInfo->getLocationList());
        $currencyLocation = $currencyInfo->getLocationList()[0];
        $this->assertEquals($location, $currencyLocation->location);
        $this->assertEquals($flagIconUrl, $currencyLocation->flagIconUrl);
    }
}
