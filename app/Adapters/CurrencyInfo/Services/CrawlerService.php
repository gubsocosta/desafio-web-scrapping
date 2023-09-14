<?php

namespace App\Adapters\CurrencyInfo\Services;

use App\Adapters\CurrencyInfo\GetCurrencyInfoByIsoCode;
use Core\Domain\Entities\CurrencyInfo;
use Core\Infra\Http\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService implements GetCurrencyInfoByIsoCode
{
    public function __construct(
        private readonly HttpClient $httpClient
    )
    {
    }

    public function getCurrencyInfoByIsoCode(string $isoCode): CurrencyInfo|null
    {
        libxml_use_internal_errors(true);
        $response = $this->httpClient->get('https://pt.wikipedia.org/wiki/ISO_4217');
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        libxml_use_internal_errors(false);
        $rawCurrencyInfo = $crawler->filterXPath("//table[contains(@class, 'wikitable')]/tbody/tr[contains(td[1], '$isoCode')]/td");
        $rawCurrencyIsoCode = $rawCurrencyInfo->getNode(0)->nodeValue;
        $rawCurrenNumericCode = $rawCurrencyInfo->getNode(1)->nodeValue;
        $rawCurrencyDecimalPlaces = $rawCurrencyInfo->getNode(2)->nodeValue;
        $rawCurrencyName = $rawCurrencyInfo->getNode(3)->nodeValue;
        $locationList = $rawCurrencyInfo->filter("td:nth-child(5) a")->each(function (Crawler $node, $i) {
            return $node->text();
        });
//        $crawler->filter("table.wikitable tbody tr:contains('$isoCode') td:nth-child(5) span.mw-image-border span img");
//
//        $locationList = $crawler->filter("table.wikitable tbody tr:contains('$isoCode') td:nth-child(5) a")->each(function (Crawler $node, $i) {
//            return $node->text();
//        });

    }
}
