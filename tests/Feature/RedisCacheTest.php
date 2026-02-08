<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\RedisService;
use Illuminate\Support\Facades\Redis;

class RedisCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushall(); // Clear Redis for testing
    }

    public function test_travel_plan_caching()
    {
        $redisService = app(RedisService::class);

        $testData = [
            'location' => 'Paris',
            'duration' => 5,
            'details' => ['hotel' => 'Test Hotel']
        ];

        // Cache data
        $redisService->cacheTravelPlan('test_ref', $testData);

        // Retrieve data
        $cachedData = $redisService->getTravelPlan('test_ref');

        $this->assertEquals($testData, $cachedData);
    }

    public function test_rate_limiting()
    {
        $redisService = app(RedisService::class);
        $ip = '127.0.0.1';

        // Should allow first 60 requests
        for ($i = 0; $i < 60; $i++) {
            $this->assertTrue($redisService->checkRateLimit($ip));
        }

        // Should block 61st request
        $this->assertFalse($redisService->checkRateLimit($ip));
    }
}
