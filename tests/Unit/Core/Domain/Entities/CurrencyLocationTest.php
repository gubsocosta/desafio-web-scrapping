<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\CurrencyLocation;
use PHPUnit\Framework\TestCase;

class CurrencyLocationTest extends TestCase
{
    public function testCurrencyLocationCreation()
    {
        $location = 'Reino Unido';
        $icon = 'https://example.com/uk-icon.png';

        $currencyLocation = new CurrencyLocation($location, $icon);

        $this->assertInstanceOf(CurrencyLocation::class, $currencyLocation);
        $this->assertEquals($location, $currencyLocation->location);
        $this->assertEquals($icon, $currencyLocation->icon);
    }
}
