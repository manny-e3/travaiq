<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\RedisService;

class RedisRateLimiter
{
    public function __construct(private RedisService $redis) {}

    public function handle($request, Closure $next)
    {
        if (!$this->redis->checkRateLimit($request->ip())) {
            return response()->json([
                'error' => 'Too many requests'
            ], 429);
        }

        return $next($request);
    }
}
