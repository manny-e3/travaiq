<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightRecommendation extends Model
{
    protected $fillable = [
        'location_overview_id',
        'best_booking_time',
        'travel_tips'
    ];

    protected $casts = [
        'travel_tips' => 'array'
    ];

    public function locationOverview()
    {
        return $this->belongsTo(LocationOverview::class);
    }

    public function airports()
    {
        return $this->hasMany(RecommendedAirport::class);
    }

    public function airlines()
    {
        return $this->hasMany(RecommendedAirline::class);
    }
}
