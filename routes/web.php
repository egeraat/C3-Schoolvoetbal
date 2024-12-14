<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Teams routes
Route::resource('teams', TeamController::class);



Route::post('teams/{team}/addPlayer', [TeamController::class, 'addPlayer'])->name('teams.addPlayer');



Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::post('/games/generate', [GameController::class, 'generate'])->name('games.generate');

Route::get('/games/generate', function () {
    return redirect()->route('games.index');
});



// Dashboard route (uses DashboardController)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authentication routes
Route::middleware('auth')->group(function () {
    // Teams resource route (automatically creates the necessary routes for create, store, edit, update, destroy)
    Route::resource('teams', TeamController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
