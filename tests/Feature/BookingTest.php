<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Court;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_booking_and_redirect_to_payment()
    {
        //  Buat user & court
        $user = User::factory()->create();
        $court = Court::factory()->create();

        //  Login sebagai user
        $this->actingAs($user);

        //  Hit endpoint booking
        $response = $this->post('/customer/booking', [
            'court_id' => $court->id,
            'booking_date' => now()->toDateString(),
            'slots' => json_encode([
                ['start' => '10:00', 'end' => '11:00']
            ])
        ]);

        //  Pastikan redirect ke payment
        $response->assertStatus(302);
        $response->assertRedirectContains('/payment/');

        //  data masuk database
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'court_id' => $court->id,
            'status' => 'pending'
        ]);
    }
}