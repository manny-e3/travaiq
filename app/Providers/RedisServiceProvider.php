<?php

namespace App\Providers;

use App\Services\RedisService;
use Illuminate\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RedisService::class);
    }
}
