<?php

use App\Actions\UpdateWebsiteSettings;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('updates website settings including logo and hero photo', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
        'kleur' => '#000000',
        'telefoonnummer' => '0100000000',
        'plaats' => 'Oldtown',
        'adres' => 'Old street 1',
        'postcode' => '0000AA',
        'hero_beschrijving' => 'Old hero',
    ]);

    $request = makeActionRequest(
        $user,
        [
            'naam' => 'Nieuwe Autobedrijf Naam',
            'email' => 'nieuw@example.com',
            'kleur' => '#FF6600',
            'hero_beschrijving' => 'Nieuwe hero tekst',
            'telefoonnummer' => '0612345678',
            'plaats' => 'Rotterdam',
            'adres' => 'Nieuweweg 10',
            'postcode' => '1234AB',
        ],
        [
            'logo' => fakeImage('logo.png'),
            'herofoto' => fakeImage('hero.png'),
        ]
    );

    $response = UpdateWebsiteSettings::run($request, $user);

    expect($response->getStatusCode())->toBe(200);

    $user->refresh();

    expect($user->name)->toBe('Nieuwe Autobedrijf Naam');
    expect($user->email)->toBe('nieuw@example.com');
    expect($user->kleur)->toBe('#FF6600');
    expect($user->hero_beschrijving)->toBe('Nieuwe hero tekst');
    expect($user->telefoonnummer)->toBe('0612345678');
    expect($user->plaats)->toBe('Rotterdam');
    expect($user->adres)->toBe('Nieuweweg 10');
    expect($user->postcode)->toBe('1234AB');
    expect($user->logo)->not->toBeNull();
    expect($user->hero_foto)->not->toBeNull();

    expect(Storage::disk('public')->exists($user->logo))->toBeTrue();
    expect(Storage::disk('public')->exists($user->hero_foto))->toBeTrue();

    $payload = $response->getData(true);

    expect($payload['success'])->toBeTrue();
    expect($payload['settings']['naam'])->toBe('Nieuwe Autobedrijf Naam');
    expect($payload['settings']['Email'])->toBe('nieuw@example.com');
    expect($payload['settings']['herofoto'])->toBe($user->hero_foto);
});

it('keeps optional settings unchanged when only required fields are provided', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
        'kleur' => '#123456',
        'telefoonnummer' => '0600000000',
        'plaats' => 'Amsterdam',
        'adres' => 'Straat 1',
        'postcode' => '1111AA',
        'hero_beschrijving' => 'Bestaande beschrijving',
        'logo' => 'logos/existing-logo.png',
        'hero_foto' => 'herofotos/existing-hero.png',
    ]);

    $request = makeActionRequest($user, [
        'naam' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $response = UpdateWebsiteSettings::run($request, $user);

    expect($response->getStatusCode())->toBe(200);

    $user->refresh();

    expect($user->name)->toBe('Updated Name');
    expect($user->email)->toBe('updated@example.com');
    expect($user->kleur)->toBe('#123456');
    expect($user->telefoonnummer)->toBe('0600000000');
    expect($user->plaats)->toBe('Amsterdam');
    expect($user->adres)->toBe('Straat 1');
    expect($user->postcode)->toBe('1111AA');
    expect($user->hero_beschrijving)->toBe('Bestaande beschrijving');
    expect($user->logo)->toBe('logos/existing-logo.png');
    expect($user->hero_foto)->toBe('herofotos/existing-hero.png');
});
