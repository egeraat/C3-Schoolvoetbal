<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    // Show the list of teams for the authenticated user
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams;  // Assuming a user has many teams

        return view('teams.index', compact('teams'));
    }

    // Show the form to create a new team
    public function create()
    {
        return view('teams.create');
    }

    // Store a newly created team
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Team::create([
            'name' => $validated['name'],
            'user_id' => Auth::id(), // Associate the team with the logged-in user
        ]);

        return redirect()->route('teams.index')->with('success', 'Team succesvol toegevoegd.');
    }

    // Show the form to edit an existing team
    public function edit(Team $team)
    {
        // Check if the logged-in user is the owner of the team
        if ($team->user_id !== auth()->id()) {
            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bewerken.');
        }

        // Get all players associated with this team
        $players = Player::where('team_id', $team->id)->get();
        return view('teams.edit', compact('team', 'players'));
    }

    // Update an existing team
    public function update(Request $request, Team $team)
    {
        // Check if the logged-in user is the owner of the team
        if ($team->user_id !== auth()->id()) {
            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bijwerken.');
        }

        // Validate the team name
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the team name
        $team->update($request->only('name'));

        return redirect()->route('teams.index')->with('success', 'Team succesvol bijgewerkt!');
    }

    // Delete a team
    public function destroy(Team $team)
    {
        // Check if the logged-in user is the owner of the team
        if ($team->user_id !== auth()->id()) {
            return redirect()->route('teams.index')->with('error', 'Je hebt geen toestemming om dit team te verwijderen.');
        }

        // Delete the team
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team succesvol verwijderd!');
    }

    // Add a player to a team
    public function addPlayer(Request $request, Team $team)
    {
        // Validate player name
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new player and associate it with the team
        $player = new Player();
        $player->name = $validated['name'];
        $player->team_id = $team->id;
        $player->save();

        // Redirect back to the team edit page with a success message
        return redirect()->route('teams.edit', $team->id)->with('success', 'Speler toegevoegd aan het team.');
    }
}
