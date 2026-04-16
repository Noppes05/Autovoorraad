<?php

use App\Actions\SyncAutoFotos;
use App\Enums\Auto_status;
use App\Models\Auto;
use App\Models\AutoFoto;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('syncs fotos by appending new fotos when replace is false', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $auto = Auto::create([
        'user_id' => $user->id,
        'kenteken' => 'SYNC01',
        'merk' => 'BMW',
        'model' => '320i',
        'bouwjaar' => 2018,
        'beschrijving' => 'Sync test',
        'prijs' => 19999,
        'km_stand' => 80000,
        'status' => Auto_status::BESCHIKBAAR,
    ]);

    Storage::disk('public')->put('uploads/existing.jpg', 'existing');

    AutoFoto::create([
        'auto_id' => $auto->id,
        'foto_path' => 'uploads/existing.jpg',
        'volgorde_nummer' => 1,
    ]);

    SyncAutoFotos::run($auto, [
        fakeImage('sync-1.png'),
        fakeImage('sync-2.png'),
    ], false);

    $fotos = AutoFoto::where('auto_id', $auto->id)->orderBy('volgorde_nummer')->get();

    expect($fotos)->toHaveCount(3);
    expect(Storage::disk('public')->exists('uploads/existing.jpg'))->toBeTrue();
});