<?php

use App\Actions\StoreNewAuto;
use App\Enums\Auto_status;
use App\Models\Auto;
use App\Models\AutoFoto;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('stores a new concept auto with fotos', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $request = makeActionRequest(
        $user,
        [
            'kenteken' => 'AB123C',
            'merk' => 'Volkswagen',
            'model' => 'Golf',
            'bouwjaar' => 2020,
            'beschrijving' => 'Nette auto',
            'prijs' => 15999.99,
            'km_stand' => 45200,
        ],
        [
            'fotos' => [
                fakeImage('car-1.png'),
                fakeImage('car-2.png'),
            ],
        ]
    );

    $auto = StoreNewAuto::run($request, Auto_status::CONCEPT);

    expect(normalizeAutoStatus($auto->status))->toBe(Auto_status::CONCEPT);

    $fotos = AutoFoto::where('auto_id', $auto->id)->orderBy('volgorde_nummer')->get();
    expect($fotos)->toHaveCount(2);
    expect($fotos->pluck('volgorde_nummer')->all())->toBe([1, 2]);

    foreach ($fotos as $foto) {
        expect(Storage::disk('public')->exists($foto->foto_path))->toBeTrue();
    }
});

it('reuses a concept auto and replaces fotos when publishing beschikbaar', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $auto = Auto::create([
        'user_id' => $user->id,
        'kenteken' => 'XX11YY',
        'merk' => 'Ford',
        'model' => 'Focus',
        'bouwjaar' => 2019,
        'beschrijving' => 'Concept',
        'prijs' => 11000,
        'km_stand' => 70000,
        'status' => Auto_status::CONCEPT,
    ]);

    Storage::disk('public')->put('uploads/old-photo.jpg', 'old');

    AutoFoto::create([
        'auto_id' => $auto->id,
        'foto_path' => 'uploads/old-photo.jpg',
        'volgorde_nummer' => 1,
    ]);

    $request = makeActionRequest(
        $user,
        [
            'kenteken' => 'XX11YY',
            'merk' => 'Ford',
            'model' => 'Focus ST',
            'bouwjaar' => 2021,
            'beschrijving' => 'Nu beschikbaar',
            'prijs' => 14500,
            'km_stand' => 60500,
        ],
        [
            'fotos' => [fakeImage('new-photo.png')],
        ]
    );

    $result = StoreNewAuto::run($request, Auto_status::BESCHIKBAAR);

    expect($result->id)->toBe($auto->id);
    expect($result->fresh()->status)->toBe(Auto_status::BESCHIKBAAR->value);
    expect($result->fresh()->model)->toBe('Focus ST');

    expect(AutoFoto::where('auto_id', $auto->id)->count())->toBe(1);
    expect(Storage::disk('public')->exists('uploads/old-photo.jpg'))->toBeFalse();
});