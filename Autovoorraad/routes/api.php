<?php

use App\Http\Controllers\AutoAPIController;
use App\Http\Controllers\AutoAPIGetController;
use App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'throttle:30,1')->group(function () {
    Route::post('/rdw/kenteken', [AutoAPIGetController::class, 'fetchFromRdw'])->name('rdw.kenteken');
    Route::get('/autos', [AutoAPIGetController::class, 'index'])->name('api.autos');
    Route::get('/autos/{id}', [AutoAPIGetController::class, 'show'])->name('api.autos.show');
    
    Route::post('/AddConceptcar', [AutoAPIController::class, 'store_concept'])->name('api.addconceptcar');
    Route::post('/Addcar', [AutoAPIController::class, 'store_beschikbaar'])->name('api.addcar');
    Route::post('/autos/{id}/update', [AutoAPIController::class, 'update_car'])->name('api.autos.update');
    Route::post('/autos/{id}/fotos', [AutoAPIController::class, 'update_fotos'])->name('api.autos.fotos.update');
    Route::post('/autos/delete', [AutoAPIController::class, 'destroy'])->name('api.autos.delete');

    Route::get('/website-settings', [WebsiteSettingsController::class, 'get'])->name('api.website-settings.get');
    Route::post('/website-settings', [WebsiteSettingsController::class, 'update'])->name('api.website-settings.update');
});