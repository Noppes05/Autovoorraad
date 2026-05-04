<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('blocks basic users from using the RDW endpoint', function () {
    $user = User::factory()->create([
        'role' => 'basic',
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/rdw/kenteken', [
        'kenteken' => '12AB34',
    ]);

    $response
        ->assertForbidden()
        ->assertJson([
            'success' => false,
            'message' => 'Alleen premium gebruikers kunnen de RDW-koppeling gebruiken.',
        ]);
});
