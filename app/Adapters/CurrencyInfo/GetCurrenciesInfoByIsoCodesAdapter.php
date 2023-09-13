<?php

namespace App\Adapters\CurrencyInfo;

use Symfony\Component\DomCrawler\Crawler;
use Core\Domain\Entities\CurrencyInfo;
use Core\Domain\UseCases\GetCurrenciesInfoByIsoCodes\Gateways\GetCurrenciesInfoByIsoCodesGateway;
use Core\Infra\Http\HttpClient;
use DOMDocument;
use DOMXPath;

libxml_use_internal_errors(true);

final class GetCurrenciesInfoByIsoCodesAdapter implements GetCurrenciesInfoByIsoCodesGateway
{
    public function __construct(
        private readonly HttpClient $httpClient
    )
    {
    }

    /**
     * @param string[] $isoCodeList
     * @return CurrencyInfo[]
     */
    public function getCurrenciesInfoByCodeList(array $isoCodeList): array
    {
        return array_map(function (string $isoCode) {
            return $this->getCurrencyInfoByIsoCode($isoCode);
        }, $isoCodeList);
    }

    private function getCurrencyInfoByIsoCode(string $isoCode)
    {
        $response = $this->httpClient->get('https://pt.wikipedia.org/wiki/ISO_4217');
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $rawCurrencyInfo = $crawler->filterXPath("//table[contains(@class, 'wikitable')]/tbody/tr[contains(td[1], '$isoCode')]/td");

        $rawCurrencyIsoCode = $rawCurrencyInfo->getNode(0)->nodeValue;
        $rawCurrenNumericCode = $rawCurrencyInfo->getNode(1)->nodeValue;
        $rawCurrencyDecimalPlaces = $rawCurrencyInfo->getNode(2)->nodeValue;
        $rawCurrencyName = $rawCurrencyInfo->getNode(3)->nodeValue;



        $rawCurrencyLocationList = arra_map();
        $crawler->filter('table.infobox tr:contains("Países que utilizam") td a')->each(function ($node) use (&$countries) {
            $countryName = $node->text();
            $countryLink = $node->attr('href');
            $countries[] = [
                'name' => $countryName,
                'flag_link' => $countryLink,
            ];
        });

        $result[] = [
            'iso_code' => $isoCode,
            'numeric_code' => $numericCode,
            'currency_name' => $currencyName,
            'countries' => $countries,
        ];
    }
}
