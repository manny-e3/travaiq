<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendedAirline extends Model
{
    protected $fillable = [
        'flight_recommendation_id',
        'name',
        'typical_price_range',
        'flight_duration',
        'notes'
    ];

    public function flightRecommendation()
    {
        return $this->belongsTo(FlightRecommendation::class);
    }
}
