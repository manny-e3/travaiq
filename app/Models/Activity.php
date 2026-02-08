<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'coordinates',
        'address',
        'cost',
        'duration',
        'best_time',
        'phone_number',
        'website',
        'fee',
        'itinerary_id',
        'image_url'
    ];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
