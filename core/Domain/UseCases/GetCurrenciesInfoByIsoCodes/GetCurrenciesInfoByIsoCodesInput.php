<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

class GetCurrenciesInfoByIsoCodesInput
{
    /**
     * @param string[] $isoCodeList
     */
    public function __construct(
        public readonly array $isoCodeList
    )
    {
    }
}
