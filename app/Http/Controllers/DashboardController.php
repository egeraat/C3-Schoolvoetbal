<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is part of any team
        $team = Team::where('user_id', $user->id)->first();

        if ($team) {
            // Get all players in the same team as the user
            $players = $team->players;  // Assuming 'players' relationship is set up in the Team model
        } else {
            $players = [];
        }

        // Pass the data to the view
        return view('dashboard', compact('team', 'players'));
    }
}
