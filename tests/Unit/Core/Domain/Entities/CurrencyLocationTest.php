<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\CurrencyLocation;
use PHPUnit\Framework\TestCase;

class CurrencyLocationTest extends TestCase
{
    public function testShouldCreateCurrencyLocation()
    {
        $location = 'Reino Unido';
        $flagIconUrl = 'https://example.com/uk-icon.png';
        $currencyLocation = new CurrencyLocation($location, $flagIconUrl);
        $this->assertInstanceOf(CurrencyLocation::class, $currencyLocation);
        $this->assertEquals($location, $currencyLocation->location);
        $this->assertEquals($flagIconUrl, $currencyLocation->flagIconUrl);
    }
}
