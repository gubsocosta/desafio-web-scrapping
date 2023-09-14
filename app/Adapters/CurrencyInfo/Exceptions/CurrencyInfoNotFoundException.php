<?php

namespace App\Adapters\CurrencyInfo\Exceptions;

use Exception;

class CurrencyInfoNotFoundException extends Exception
{
    public function __construct(string $isoCode, int $code = 0, ?Throwable $previous = null)
    {
        $message = "there is no information about the currency $isoCode";
        parent::__construct($message, $code, $previous);
    }
}
