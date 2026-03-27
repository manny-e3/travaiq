<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestTravelPlan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'plan_data'   => 'array',
        'travel_date' => 'date',
    ];
}
