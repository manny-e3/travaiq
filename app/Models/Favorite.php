<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'trip_detail_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tripDetail()
    {
        return $this->belongsTo(TripDetail::class);
    }
}
