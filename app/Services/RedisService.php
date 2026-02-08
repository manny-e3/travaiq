<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    // Cache TTL (1 hour by default)
    const DEFAULT_TTL = 3600;

    /**
     * Cache travel plan
     */
    public function cacheTravelPlan(string $referenceCode, array $data)
    {
        Redis::setex(
            "travel_plan:{$referenceCode}",
            self::DEFAULT_TTL,
            json_encode($data)
        );
    }

    /**
     * Get cached travel plan
     */
    public function getTravelPlan(string $referenceCode)
    {
        $data = Redis::get("travel_plan:{$referenceCode}");
        return $data ? json_decode($data, true) : null;
    }

    /**
     * Cache user's recent searches
     */
    public function addRecentSearch(int $userId, array $searchData)
    {
        Redis::lpush("user:{$userId}:recent_searches", json_encode($searchData));
        Redis::ltrim("user:{$userId}:recent_searches", 0, 4); // Keep only 5 recent searches
    }

    /**
     * Get user's recent searches
     */
    public function getRecentSearches(int $userId)
    {
        $searches = Redis::lrange("user:{$userId}:recent_searches", 0, -1);
        return array_map(fn($search) => json_decode($search, true), $searches);
    }

    /**
     * Implement rate limiting
     */
    public function checkRateLimit(string $ip, int $maxAttempts = 60)
    {
        $key = "rate_limit:{$ip}";
        $attempts = Redis::incr($key);

        if ($attempts === 1) {
            Redis::expire($key, 60); // Reset after 1 minute
        }

        return $attempts <= $maxAttempts;
    }
}
