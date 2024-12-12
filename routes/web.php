<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::resource('teams', TeamController::class);

Route::post('teams/{team}/addPlayer', [TeamController::class, 'addPlayer'])->name('teams.addPlayer');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Beveiliging voor routes waar je ingelogd moet zijn
Route::middleware('auth')->group(function () {
    // Hier is alleen de resource-route voor teams nodig
    Route::resource('teams', TeamController::class);
    
    // Profielbeheer
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
