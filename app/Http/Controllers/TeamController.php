<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Toon alle teams
    public function index()
    {
        $teams = Team::all(); // Haal alle teams op
        return view('teams.index', compact('teams'));
    }

    // Toon formulier voor nieuw team
    public function create()
    {
        return view('teams.create');
    }

    // Sla nieuw team op
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']); // Validatie
        Team::create($request->all()); // Opslaan
        return redirect()->route('teams.index')->with('success', 'Team toegevoegd!');
    }

    // Toon formulier voor bewerken van een team
    public function edit(Team $team)
    {
        $players = Player::all(); // Haal alle spelers op
        return view('teams.edit', compact('team', 'players'));
    }

    // Update een team
    public function update(Request $request, Team $team)
    {
        $request->validate(['name' => 'required']);
        $team->update($request->all());
        return redirect()->route('teams.index')->with('success', 'Team bijgewerkt!');
    }

    // Verwijder een team
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team verwijderd!');
    }

    // Voeg speler toe aan een team
    public function addPlayer(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required', // Speler naam verplicht
        ]);

        // Maak de speler aan en koppel deze aan het team
        $player = new Player();
        $player->name = $request->name;
        $player->team_id = $team->id;
        $player->save();

        return redirect()->route('teams.edit', $team->id)->with('success', 'Speler toegevoegd!');
    }
}
