<?php

namespace Core\Infra\Caching;

interface CacheClient
{
    public function get(string|int $key): mixed;

    public function put(string|int $key, mixed $value, int $minutes): void;

    public function has(string|int $key): bool;
}
