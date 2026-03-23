<?php

namespace App\Services;

use App\Models\TripDetail;

class SustainabilityService
{
    /**
     * Calculate the approximate carbon footprint for a trip in kg CO2.
     * 
     * @param TripDetail $trip
     * @return array ['total' => int, 'breakdown' => array, 'score' => string]
     */
    public function calculateTripFootprint(TripDetail $trip): array
    {
        $travelers = (int) $trip->traveler; // e.g. "2" or "Couple" -> need to parse if string
        if (!is_numeric($travelers)) {
            // Simple mapping for non-numeric traveler strings
            $travelers = match(strtolower($trip->traveler)) {
                'solo' => 1,
                'couple' => 2,
                'family' => 4,
                'friends' => 4,
                default => 2
            };
        }
        
        if ($travelers < 1) $travelers = 1;

        $days = (int) $trip->duration;
        if ($days < 1) $days = 1;

        // 1. Accommodation (kg CO2 per room per night)
        // Avg hotel: 15-30 kg CO2/night. Let's assume 20.
        // Rooms needed: ceil(travelers / 2)
        $rooms = ceil($travelers / 2);
        $accommodationFootprint = $rooms * $days * 20;

        // 2. Transport (Flight to destination) - ESTIMATE
        // We don't have origin always, but let's assume a medium haul flight (200kg per person)
        // If origin is set in session or trip, we could be more specific, but for now:
        $transportFootprint = $travelers * 200; 

        // 3. Activities
        // Assume minimal impact for sightseeing, but some for transport.
        // 5kg per day per person for local transport/food impact delta
        $activitiesFootprint = $travelers * $days * 5;

        $total = $accommodationFootprint + $transportFootprint + $activitiesFootprint;

        // Score (A is best, F is worst) based on daily footprint per person
        $perPersonDays = $travelers * $days;
        $perPersonPerDay = $perPersonDays > 0 ? $total / $perPersonDays : 0;
        
        $grade = match(true) {
            $perPersonPerDay < 15 => 'A',
            $perPersonPerDay < 25 => 'B',
            $perPersonPerDay < 40 => 'C',
            $perPersonPerDay < 60 => 'D',
            default => 'E'
        };

        return [
            'total' => round($total),
            'per_person' => $travelers > 0 ? round($total / $travelers) : 0,
            'breakdown' => [
                'transport' => $transportFootprint,
                'accommodation' => $accommodationFootprint,
                'activities' => $activitiesFootprint
            ],
            'grade' => $grade
        ];
    }
}
