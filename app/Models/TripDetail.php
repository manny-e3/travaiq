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
        'is_public',
        'slug',
        'meta_title',
        'meta_description',
    ];

    public function locationOverview()
    {
        return $this->belongsTo(LocationOverview::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSeoSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->location);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'trip_detail_id', 'user_id')->withTimestamps();
    }

    public function isFavoritedBy($user)
    {
        if (!$user) return false;
        $userId = $user instanceof User ? $user->id : $user;
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }
}
