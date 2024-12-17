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
        $teams = Team::with('users', 'user')->get();
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
        if (($team->user_id !== auth()->id()) && !auth()->user()->is_admin && auth()->user()->email !== 'admin@example.com') {

            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bewerken.');
        }

        $players = Player::all();

        return view('teams.edit', compact('team', 'players'));
    }


    public function update(Request $request, Team $team)
    {
        if (($team->user_id !== auth()->id()) && !auth()->user()->is_admin && auth()->user()->email !== 'admin@example.com') {

            return redirect()->route('teams.index')->with('error', 'Je mag dit team niet bijwerken.');
        }

        $request->validate(['name' => 'required']);





        $team->update($request->only('name'));

        return redirect()->route('teams.index')->with('success', 'Team bijgewerkt!');
    }


    public function destroy(Team $team)
    {
        // Controleer of de gebruiker een admin is of de eigenaar van het team
        if (($team->user_id !== auth()->id()) && !auth()->user()->is_admin && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('teams.index')->with('error', 'Je hebt geen toestemming om dit team te verwijderen.');
        }

        // Verwijder het team
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team succesvol verwijderd!');
    }


    public function addPlayer(Request $request, Team $team)
{
    $user = auth()->user();

    // Controleer of de gebruiker al in een ander team zit
    if ($user->team) {
        return redirect()->back()->with('error', 'Je zit al in een ander team.');
    }

    // Voeg de gebruiker toe aan dit team
    $user->team_id = $team->id;
    $user->save();

    return redirect()->back()->with('success', 'Je bent succesvol toegevoegd aan het team.');
}
    public function updateScore(Request $request, $id)
{
    // Valideer de input
    $request->validate([
        'uitslg' => 'required|regex:/^\d+-\d+$/',
    ]);

    // Haal de wedstrijd op
    $game = Game::findOrFail($id);

    // Uitslag opslaan in de game-tabel
    $game->uitslg = $request->input('uitslg');
    $game->save();

    // Uitslag splitsen in goals
    [$team1Goals, $team2Goals] = explode('-', $game->uitslg);

    // Bereken punten
    if ($team1Goals > $team2Goals) {
        // Team 1 wint
        $game->team1->points += 3;
    } elseif ($team1Goals < $team2Goals) {
        // Team 2 wint
        $game->team2->points += 3;
    } else {
        // Gelijkspel
        $game->team1->points += 1;
        $game->team2->points += 1;
    }

    // Sla de nieuwe punten op in de teams-tabel
    $game->team1->save();
    $game->team2->save();

    return redirect()->back()->with('success', 'Uitslag en punten succesvol bijgewerkt!');
}
public function joinTeam(Request $request, Team $team)
{
    $user = auth()->user();

    // Controleer of de gebruiker al in een ander team zit
    if ($user->team) {
        return redirect()->back()->with('error', 'Je zit al in een ander team.');
    }

    // Voeg de gebruiker toe aan dit team
    $user->team_id = $team->id;
    $user->save();

    return redirect()->back()->with('success', 'Je bent succesvol toegevoegd aan het team.');
}
public function teamFullView(Team $team)
{
    // Laad alle benodigde relaties, zoals gebruikers en de maker
    $team->load('users', 'user');

    // Stuur het specifieke team naar de view
    return view('teams.team-full-view', compact('team'));
}

}