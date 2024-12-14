<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('team1', 'team2')->get();
        return view('games.index', compact('games'));
    }

    // Toon het formulier voor het genereren van het schema
    public function show()
    {
        // Haal alle wedstrijden op (indien er al een schema is gegenereerd)
        $games = Game::all();
        
        return view('games.index', compact('games'));
    }

    // Genereer de wedstrijden voor een halve competitie
    public function generate(Request $request, Team $team)
    {
        // Controleer of de ingelogde gebruiker een beheerder is
        if ($team->user_id !== auth()->id() && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('games.index')->with('error', 'Je hebt geen toestemming om dit team te verwijderen.');
        }

        // Verwijder het oude schema (alle bestaande wedstrijden)
        Game::truncate(); // Dit verwijdert alle records uit de games-tabel

        // Haal alle teams op
        $teams = Team::all();

        // Array om het schema in op te slaan
        $games = [];

        // Genereer het schema (halve competitie)
        for ($i = 0; $i < count($teams); $i++) {
            for ($j = $i + 1; $j < count($teams); $j++) {
                $games[] = [
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id,
                    'status' => 'pending', // Of een andere status zoals 'gepland'
                ];
            }
        }

        // Voeg het schema toe aan de database (bijvoorbeeld via een batch insert)
        Game::insert($games);

        return redirect()->route('games.index')->with('success', 'Wedstrijdschema gegenereerd!');
    }
}
