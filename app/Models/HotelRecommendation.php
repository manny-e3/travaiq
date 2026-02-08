<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRecommendation extends Model
{
    use HasFactory;

    protected $table = 'agoda_hotel_recommendations';

    protected $fillable = [
        'location_overview_id', 'name', 'description', 'address', 'rating', 'price', 'currency',
        'image_url', 'amenities', 'location', 'review_score', 'review_count', 'booking_url'
    ];
    

    protected $casts = [
        'amenities' => 'array',
        'location' => 'array',
        'rating' => 'float',
        'price' => 'float',
        'review_score' => 'float'
    ];

    public function locationOverview()
    {
        return $this->belongsTo(LocationOverview::class);
    }
}
