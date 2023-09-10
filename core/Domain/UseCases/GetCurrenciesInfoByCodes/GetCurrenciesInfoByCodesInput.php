<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByCodes;

class GetCurrenciesInfoByCodesInput
{
    /**
     * @param array<string> $codeList
     */
    public function __construct(
        public readonly array $codeList
    )
    {
    }
}
