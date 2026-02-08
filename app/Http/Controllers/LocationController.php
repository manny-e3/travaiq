<?php

namespace App\Http\Controllers;

use App\Traits\UsesRedisCache;

class LocationController extends Controller
{
    use UsesRedisCache;

    public function getPopularLocations()
    {
        $key = $this->cacheKey('popular_locations', 'all');

        return $this->rememberCache($key, 3600, function () {
            return Location::withCount('visits')
                ->orderBy('visits_count', 'desc')
                ->limit(10)
                ->get();
        });
    }
}
