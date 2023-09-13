<?php

namespace Core\Infra\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    public function get(string $url, array $headers = []): ResponseInterface;
}
