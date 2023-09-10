<?php

namespace Core\Domain\UseCases\GetCurrenciesInfoByCodes;

use Core\Domain\UseCases\GetCurrenciesInfoByCodes\Gateways\GetCurrenciesInfoByCodesGateway;
use Core\Infra\Log\Logger;

final class GetCurrenciesInfoByCodesUseCase
{

    public function __construct(
        private readonly Logger $logger,
        private readonly GetCurrenciesInfoByCodesGateway $gateway
    )
    {
    }

    public function execute(GetCurrenciesInfoByCodesInput $input): GetCurrenciesInfoByCodesOutput
    {
        try {
            $result = $this->gateway->getCurrenciesInfoByCodeList($input->codeList);
            return new GetCurrenciesInfoByCodesOutput($result);
        } catch (\Error $error) {
            $this->logger->error('Error in GetCurrenciesInfoByCodesUseCase: ' . $error->getMessage());
            throw $error;
        }
    }
}
