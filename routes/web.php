<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::resource('teams', TeamController::class); // Dit maakt alle standaard resource routes voor teams

// Route voor het toevoegen van spelers aan een team
Route::post('teams/{team}/addPlayer', [TeamController::class, 'addPlayer'])->name('teams.addPlayer');

// Home route (deze wordt als 'dashboard' route gebruikt)
Route::get('/', function () {
    return view('welcome'); // Dit toont de welkomstpagina bij toegang tot de root URL
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard'); // Dit toont de dashboardpagina
})->middleware(['auth', 'verified'])->name('dashboard'); // Middleware om toegang te beperken tot ingelogde gebruikers

// Authenticatie routes (zoals profielpagina, update, etc.)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Profiel bewerken
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Profiel updaten
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Profiel verwijderen
});

// Vergeet niet de authenticatieroutes in te laden (standaard Laravel auth)
require __DIR__.'/auth.php';

