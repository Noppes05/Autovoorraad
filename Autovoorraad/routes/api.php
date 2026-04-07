<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/api/rdw/kenteken', [AutoController::class, 'fetchFromRdw'])->middleware(['auth:sanctum'])->name('rdw.kenteken');

