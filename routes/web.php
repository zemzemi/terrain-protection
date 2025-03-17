<?php

use App\Http\Controllers\TerrainProtectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TerrainProtectionController::class, 'index'])->name('terrain-protection.index');
Route::post('/terrain-protection/calculate', [TerrainProtectionController::class, 'calculate'])
    ->name('terrain-protection.calculate');
