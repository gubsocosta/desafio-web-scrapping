<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\Entities\CurrencyLocation;
use PHPUnit\Framework\TestCase;

class CurrencyInfoTest extends TestCase
{

    public function testCurrencyInfoResponseCreation()
    {
        $currencyCode = 'GBP';
        $number = 826;
        $decimalPlaces = 2;
        $currencyName = 'Libra Esterlina';

        $currencyInfo = new CurrencyInfo($currencyCode, $number, $decimalPlaces, $currencyName);

        $this->assertInstanceOf(CurrencyInfo::class, $currencyInfo);
        $this->assertEquals($currencyCode, $currencyInfo->code);
        $this->assertEquals($number, $currencyInfo->number);
        $this->assertEquals($decimalPlaces, $currencyInfo->decimalPlaces);
        $this->assertEquals($currencyName, $currencyInfo->name);
    }

    public function testAddLocation()
    {
        $currencyInfo = new CurrencyInfo('GBP', 826, 2, 'Libra Esterlina');
        $location = 'Reino Unido';
        $icon = 'https://example.com/uk-icon.png';
        $currencyInfo->addLocation(new CurrencyLocation($location, $icon));

        $this->assertCount(1, $currencyInfo->getLocationList());

        $currencyLocation = $currencyInfo->getLocationList()[0];
        $this->assertEquals($location, $currencyLocation->location);
        $this->assertEquals($icon, $currencyLocation->icon);
    }
}
