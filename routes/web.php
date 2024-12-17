<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Models\Team;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Teams routes
Route::resource('teams', TeamController::class)->middleware('auth');
Route::post('/teams/{team}/join', [TeamController::class, 'joinTeam'])->name('teams.join');

// Games routes
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::post('/games/generate', [GameController::class, 'generate'])->name('games.generate');
Route::get('/wedstrijdschema', [GameController::class, 'viewSchema'])->name('games.view');
Route::post('/games/{game}/update-score', [GameController::class, 'updateScore'])->name('games.updateScore');
Route::post('/games/update-uitslag', [GameController::class, 'updateUitslag'])->name('games.updateUitslag');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Password reset routes
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');

Route::get('/ranking', function () {
    // Teams ophalen en sorteren op punten (aflopend)
    $teams = Team::orderBy('points', 'desc')->get();
    return view('ranking', compact('teams'));
})->name('ranking.index');

// Admin routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::patch('/admin/{id}/toggle', [AdminController::class, 'toggleAdmin'])->name('admin.toggle');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/destroy/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::put('/admin/update', [AdminController::class, 'store'])->name('admin.update');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
