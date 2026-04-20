<?php

use App\Http\Controllers\AutoAPIController;
use App\Http\Controllers\AutoAPIGetController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::domain('{tenant}.'.parse_url(config('app.url'), PHP_URL_HOST))->group(function () {
    Route::get('/', function ($tenant) {
        return 'Tenant: '.$tenant;
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/auto-toevoegen', [AutoController::class, 'AutoToevoegen'])->name('auto.toevoegen');
    Route::get('/auto/{id}', [AutoController::class, 'details'])->name('auto.detail');
    Route::get('/auto/{id}/bewerken', [AutoController::class, 'edit'])->name('auto.edit');
    Route::get('/auto/{id}/fotos', [AutoController::class, 'manageFotos'])->name('auto.fotos.manage');

    Route::get('/settings', [WebsiteSettingsController::class, 'index'])->name('Website settings');

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
