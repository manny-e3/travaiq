<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait UsesRedisCache
{
    protected function cacheKey(string $type, string $identifier): string
    {
        return "{$type}:{$identifier}";
    }

    protected function rememberCache(string $key, int $ttl, callable $callback)
    {
        $cached = Redis::get($key);

        if ($cached) {
            return json_decode($cached, true);
        }

        $fresh = $callback();
        Redis::setex($key, $ttl, json_encode($fresh));

        return $fresh;
    }
}
