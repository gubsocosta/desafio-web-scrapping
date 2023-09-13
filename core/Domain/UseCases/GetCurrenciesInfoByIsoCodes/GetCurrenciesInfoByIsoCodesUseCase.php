<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes;

use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Infra\Log\Logger;
use Exception;

final class GetCurrenciesInfoByIsoCodesUseCase
{

    public function __construct(
        private readonly Logger $logger,
        private readonly GetCurrenciesInfoByIsoCodesGateway $gateway
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(GetCurrenciesInfoByIsoCodesInput $input): GetCurrenciesInfoByIsoCodesOutput
    {
        try {
            $result = $this->gateway->getCurrenciesInfoByCodeList($input->isoCodeList);
            return new GetCurrenciesInfoByIsoCodesOutput($result);
        } catch (Exception $exception) {
            $this->logger->error('Error when getting currencies information by codes: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
