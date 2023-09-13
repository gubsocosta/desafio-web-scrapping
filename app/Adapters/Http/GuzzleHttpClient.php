<?php

namespace App\Adapters\Http;

use Core\Infra\Http\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements HttpClient
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url, array $headers = []): ResponseInterface
    {
        return $this->client->get($url, ['headers' => $headers]);
    }
}
