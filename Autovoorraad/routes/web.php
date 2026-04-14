<?php

use App\Http\Controllers\AutoAPIController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::domain('{tenant}.' . parse_url(config('app.url'), PHP_URL_HOST))->group(function () {
    Route::get('/', function ($tenant) {
        return "Tenant: " . $tenant;
    });
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/auto-toevoegen', [AutoController::class, 'AutoToevoegen'])->name('auto.toevoegen');
    Route::get('/auto/{id}', [AutoController::class,'details'])->name('auto.detail');
    
});



Route::middleware('auth:sanctum','throttle:30,1')->group(function() {
    Route::post('/api/rdw/kenteken', [AutoController::class, 'fetchFromRdw'])->name('rdw.kenteken');
    Route::post('/api/AddConceptcar', [AutoAPIController::class, 'store_concept'])->name('api.addconceptcar');
    Route::post('/api/Addcar', [AutoAPIController::class, 'store_beschikbaar'])->name('api.addcar');
    Route::get('api/autos', [AutoAPIController::class, 'index'])->name('api.autos');
    Route::get('api/autos/{id}', [AutoAPIController::class, 'show'])->name('api.autos.show');
    Route::post('/api/autos/delete/', [AutoAPIController::class, 'destroy'])->name('api.autos.delete');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
