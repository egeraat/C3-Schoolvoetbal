<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;

// Home route
// Test om te kijken of mijn github werkt, ik haal dit na mijn push weer weg.
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

Route::get('/wedstrijdschema', [GameController::class, 'viewSchema'])->name('games.view');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');



Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::patch('/admin/{id}/toggle', [AdminController::class, 'toggleAdmin'])->name('admin.toggle');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/destroy/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::post('/admin/update', [AdminController::class, 'store'])->name('admin.update');
Route::post('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.toggle');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::put('/admin/update', [AdminController::class, 'store'])->name('admin.update');


Route::middleware('auth')->group(function () {
    Route::resource('teams', TeamController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
