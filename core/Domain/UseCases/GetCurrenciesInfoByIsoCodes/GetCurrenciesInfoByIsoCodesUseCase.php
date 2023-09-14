<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Rules\GetCurrenciesInfoByIsoCodesRule;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Rules\MapCurrenciesInfoToOutputRule;
use Core\Infra\Log\Logger;
use Exception;

final class GetCurrenciesInfoByIsoCodesUseCase
{
    private GetCurrenciesInfoByIsoCodesRule $getCurrenciesInfoByIsoCodesRule;
    private MapCurrenciesInfoToOutputRule $mapCurrenciesInfoToOutputRule;

    public function __construct(
        private readonly Logger                             $logger,
        private readonly GetCurrenciesInfoByIsoCodesGateway $gateway,
    )
    {
        $this->getCurrenciesInfoByIsoCodesRule = new GetCurrenciesInfoByIsoCodesRule($this->gateway);
        $this->mapCurrenciesInfoToOutputRule = new MapCurrenciesInfoToOutputRule();
    }

    /**
     * @throws Exception
     */
    public function execute(GetCurrenciesInfoByIsoCodesInput $input): GetCurrenciesInfoByIsoCodesOutput
    {
        try {
            $currencyInfoList = $this->getCurrenciesInfoByIsoCodesRule->handle($input->isoCodeList);
            $mappedCurrencyInfoList = $this->mapCurrenciesInfoToOutputRule->handle($currencyInfoList);
            return new GetCurrenciesInfoByIsoCodesOutput($mappedCurrencyInfoList);
        } catch (Exception $exception) {
            $this->logger->error('Error when getting currencies information by iso codes: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
