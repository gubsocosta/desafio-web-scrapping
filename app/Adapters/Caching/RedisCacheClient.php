<?php

namespace App\Adapters\Caching;

use Core\Infra\Caching\CacheClient;
use Illuminate\Support\Facades\Cache;


class RedisCacheClient implements CacheClient
{
    public function get(string|int $key): mixed
    {
        return Cache::get($key);
    }

    public function put(string|int $key, mixed $value, int $minutes): void
    {
        Cache::put($key, $value, $minutes);
    }

    public function has(string|int $key): bool
    {
        return Cache::has($key);
    }
}
