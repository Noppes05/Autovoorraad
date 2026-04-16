<?php

use App\Actions\UpdateCar;
use App\Enums\Auto_status;
use App\Models\Auto;
use App\Models\AutoFoto;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

it('updates car data and fotos', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $auto = Auto::create([
        'user_id' => $user->id,
        'kenteken' => 'UPD001',
        'merk' => 'Audi',
        'model' => 'A3',
        'bouwjaar' => 2017,
        'beschrijving' => 'Voor update',
        'prijs' => 12000,
        'km_stand' => 120000,
        'status' => Auto_status::CONCEPT,
    ]);

    Storage::disk('public')->put('uploads/update-old.jpg', 'old');

    AutoFoto::create([
        'auto_id' => $auto->id,
        'foto_path' => 'uploads/update-old.jpg',
        'volgorde_nummer' => 1,
    ]);

    $request = makeActionRequest(
        $user,
        [
            'kenteken' => 'UPD002',
            'merk' => 'Audi',
            'model' => 'A4',
            'bouwjaar' => 2020,
            'beschrijving' => 'Na update',
            'prijs' => 21000,
            'km_stand' => 50000,
            'status' => Auto_status::BESCHIKBAAR->value,
            'replace_fotos' => 1,
        ],
        [
            'fotos' => [fakeImage('update-new.png')],
        ]
    );

    $updated = UpdateCar::run($request, $auto);

    expect($updated->fresh()->kenteken)->toBe('UPD002');
    expect($updated->fresh()->model)->toBe('A4');
    expect($updated->fresh()->status)->toBe(Auto_status::BESCHIKBAAR->value);

    expect(AutoFoto::where('auto_id', $auto->id)->count())->toBe(1);
    expect(Storage::disk('public')->exists('uploads/update-old.jpg'))->toBeFalse();
});

it('throws when UpdateCar would duplicate kenteken for the same user', function () {
    $user = User::factory()->create();

    $target = Auto::create([
        'user_id' => $user->id,
        'kenteken' => 'AA11BB',
        'merk' => 'Opel',
        'model' => 'Corsa',
        'bouwjaar' => 2016,
        'beschrijving' => null,
        'prijs' => 6500,
        'km_stand' => 140000,
        'status' => Auto_status::CONCEPT,
    ]);

    Auto::create([
        'user_id' => $user->id,
        'kenteken' => 'DUP999',
        'merk' => 'Opel',
        'model' => 'Astra',
        'bouwjaar' => 2018,
        'beschrijving' => null,
        'prijs' => 9000,
        'km_stand' => 100000,
        'status' => Auto_status::BESCHIKBAAR,
    ]);

    $request = makeActionRequest($user, [
        'kenteken' => 'DUP999',
        'merk' => 'Opel',
        'model' => 'Corsa',
        'bouwjaar' => 2016,
        'beschrijving' => null,
        'prijs' => 6500,
        'km_stand' => 140000,
        'status' => Auto_status::BESCHIKBAAR->value,
    ]);

    UpdateCar::run($request, $target);
})->throws(UnprocessableEntityHttpException::class);