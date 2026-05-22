<?php

use App\Models\User;
use Laravel\Dusk\Browser;

test('dashboard page is available to an authenticated user', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/dashboard')
            ->assertSee('Autovoorraad')
            ->assertSee("Auto's in Voorraad");
    });
});

test('profile page shows the profile sections', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/profile')
            ->assertSee('Profile Information')
            ->assertSee('Update Password')
            ->assertSee('Delete Account');
    });
});