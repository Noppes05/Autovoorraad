<?php

use App\Http\Controllers\AutoAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoController;



Route::post('/api/rdw/kenteken', [AutoController::class, 'fetchFromRdw'])->middleware(['auth:sanctum'])->name('rdw.kenteken');

Route::middleware('auth:sanctum','throttle:15,1')->post('/api/Addcar', [AutoAPIController::class, 'store'])->name('api.addcar');

