<?php

use App\Actions\FetchRdw;

it('extracts and formats RDW values in FetchRdw helper methods', function () {
    $action = new FetchRdw();

    $extractMethod = new ReflectionMethod(FetchRdw::class, 'extractBouwjaar');
    $extractMethod->setAccessible(true);

    $formatMethod = new ReflectionMethod(FetchRdw::class, 'formatVehicleData');
    $formatMethod->setAccessible(true);

    expect($extractMethod->invoke($action, '20210430'))->toBe('2021');
    expect($extractMethod->invoke($action, null))->toBeNull();

    $formatted = $formatMethod->invoke($action, [
        'kenteken' => '12AB34',
        'merk' => 'Toyota',
        'handelsbenaming' => 'Yaris',
        'datum_eerste_tenaamstelling_in_nederland' => '20190321',
        'kilometerstand' => '123456',
    ]);

    expect($formatted)->toBe([
        'kenteken' => '12AB34',
        'merk' => 'Toyota',
        'model' => 'Yaris',
        'bouwjaar' => '2019',
        'kilometer_stand' => '123456',
    ]);
});
