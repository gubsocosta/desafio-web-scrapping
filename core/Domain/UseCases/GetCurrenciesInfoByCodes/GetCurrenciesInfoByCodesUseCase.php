<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByCodes;

use Core\Domain\UseCases\GetCurrenciesInfoByCodes\Gateways\GetCurrenciesInfoByCodesGateway;
use Core\Infra\Log\Logger;
use Exception;

final class GetCurrenciesInfoByCodesUseCase
{

    public function __construct(
        private readonly Logger $logger,
        private readonly GetCurrenciesInfoByCodesGateway $gateway
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(GetCurrenciesInfoByCodesInput $input): GetCurrenciesInfoByCodesOutput
    {
        try {
            $result = $this->gateway->getCurrenciesInfoByCodeList($input->codeList);
            return new GetCurrenciesInfoByCodesOutput($result);
        } catch (Exception $exception) {
            $this->logger->error('Error when getting currencies information by codes: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
