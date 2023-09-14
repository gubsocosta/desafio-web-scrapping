<?php

namespace Core\Domain\Entities;

final class CurrencyLocation
{
    public function __construct(
        public readonly string      $location,
        public readonly string|null $flagIconUrl = null
    )
    {
    }
}
