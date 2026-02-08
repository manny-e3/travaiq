<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDetail extends Model
{
    protected $fillable = [
        'reference_code',
        'google_place_image',
        'location',
        'duration',
        'traveler',
        'budget',
        'activities',
        'location_overview_id',
        'user_id',
        'checkInDate',
        'checkOutDate',
    ];

    public function locationOverview()
    {
        return $this->belongsTo(LocationOverview::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
