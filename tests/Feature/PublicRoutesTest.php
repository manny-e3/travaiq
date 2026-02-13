<?php

namespace Tests\Feature;

use App\Models\TripDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    // use RefreshDatabase; // Commented out to avoid wiping local DB if user prefers

    public function test_homepage_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Design Your');
        // $response->assertSee('Recent Itineraries'); // Uncomment if we seed data, but might be empty if no pub trips
    }

    public function test_public_trip_page_loads()
    {
        // Create a dummy trip if using RefreshDatabase, otherwise relies on existing data or we create and delete
        // For safety in this environment, I'll try to find an existing one or create one distinctively
        
        $trip = new TripDetail();
        $trip->is_public = true;
        $trip->location = 'TestCity_' . rand(1000, 9999);
        $trip->duration = 5;
        $trip->reference_code = 'REF' . rand(1000, 9999);
        $trip->traveler = 'Solo'; // Default value
        $trip->budget = 'Standard'; // Default value
        $trip->activities = 'Sightseeing'; // Default value
        $trip->user_id = 1; // Assuming a user exists or nullable, but let's provide if creating new
        // Actually, user_id might be required. Let's create a user or use factory if available.
        // But since we are doing `new TripDetail`, let's just fill required fields.
        if (User::count() == 0) {
             User::factory()->create();
        }
        $trip->user_id = User::first()->id;
        $trip->save(); 

        $response = $this->get(route('public.trip.show', ['reference' => $trip->reference_code, 'location' => \Illuminate\Support\Str::slug($trip->location)]));
        
        $response->assertStatus(200);
        $response->assertSee($trip->location);

        // Cleanup
        $trip->delete();
    }

    public function test_public_trip_index_loads()
    {
        $response = $this->get(route('public.trip.index'));
        $response->assertStatus(200);
    }
    
    public function test_private_trip_returns_404()
    {
        if (User::count() == 0) {
             User::factory()->create();
        }

        $trip = new TripDetail();
        $trip->is_public = false;
        $trip->location = 'PrivateCity_' . rand(1000, 9999);
        $trip->duration = 5;
        $trip->reference_code = 'PRIV' . rand(1000, 9999);
        $trip->traveler = 'Solo';
        $trip->budget = 'Standard';
        $trip->activities = 'Relaxation';
        $trip->user_id = User::first()->id;
        $trip->save();
        
        $response = $this->get('/trip/' . $trip->reference_code . '-some-slug');
        
        $response->assertStatus(404);
        
        $trip->delete();
    }
}
