<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all(); 
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
         $validated = $request->validate([
        'name' => 'required|string|max:255',
        ]);

 
        Team::create([
            'name' => $validated['name'],
            'user_id' => Auth::id(), 
        ]);

        return redirect()->route('teams.index')->with('success', 'Team succesvol toegevoegd.');
    }

    public function edit(Team $team)
    {
        if ($team->user_id !== auth()->id() && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bewerken.');
        }

        $players = Player::all();
        return view('teams.edit', compact('team', 'players'));
    }

    public function update(Request $request, Team $team)
    {
        if ($team->user_id !== auth()->id() && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bijwerken.');
        }

        $request->validate(['name' => 'required']);
        $team->update($request->only('name')); 

        return redirect()->route('teams.index')->with('success', 'Team bijgewerkt!');
    }

    public function destroy(Team $team)
    {
        // Controleer of de gebruiker een admin is of de eigenaar van het team
        if ($team->user_id !== auth()->id() && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('teams.index')->with('error', 'Je hebt geen toestemming om dit team te verwijderen.');
        }
    
        // Verwijder het team
        $team->delete();
    
        return redirect()->route('teams.index')->with('success', 'Team succesvol verwijderd!');
    }

    public function addPlayer(Request $request, Team $team)
    {
        if ($team->user_id !== auth()->id()) {
            return redirect()->route('teams.index')->with('error', 'Je mag geen spelers aan dit team toevoegen.');
        }

        $request->validate([
            'name' => 'required', 
        ]);

        $player = new Player();
        $player->name = $request->name;
        $player->team_id = $team->id;
        $player->save();

        return redirect()->route('teams.edit', $team->id)->with('success', 'Speler toegevoegd!');
    }
}
