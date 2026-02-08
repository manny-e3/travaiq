<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendedAirport extends Model
{
    protected $fillable = [
        'flight_recommendation_id',
        'name',
        'code',
        'distance_to_city'
    ];

    public function flightRecommendation()
    {
        return $this->belongsTo(FlightRecommendation::class);
    }
}
