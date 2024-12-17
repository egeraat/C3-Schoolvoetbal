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
    
    public function viewSchema()
    {
        $games = Game::with('team1', 'team2')->get(); 
        return view('games.schema', compact('games')); 
    }
    
    public function show()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }

    public function generate(Request $request, Team $team)
    {
        \App\Models\Team::query()->update(['points' => 0]);

        // Controleer of de gebruiker admin is via e-mail of via de is_admin kolom
        if (($team->user_id !== auth()->id()) && !auth()->user()->is_admin && auth()->user()->email !== 'admin@example.com') {
            return redirect()->route('games.index')->with('error', 'Je hebt geen toestemming.');
        }

        $request->validate([
            'fields' => 'required|integer|min:1',
        ]);

        $fields = $request->input('fields');

        Game::truncate(); 

        $teams = Team::all();

        $games = [];
        $fieldCounter = 1;

        for ($i = 0; $i < count($teams); $i++) {
            for ($j = $i + 1; $j < count($teams); $j++) {
                $games[] = [
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id,
                    'status' => 'pending',
                    'field' => $fieldCounter,
                ];

                $fieldCounter++;
                if ($fieldCounter > $fields) {
                    $fieldCounter = 1;
                }
            }
        }

        Game::insert($games);

        return redirect()->route('games.index')->with('success', 'Wedstrijdschema gegenereerd met ' . $fields . ' velden!');
    }

    public function updateScore(Request $request, $id)
    {
        // Haal de wedstrijd op
        $game = Game::findOrFail($id);
    
        // Valideer de input
        $request->validate([
            'uitslag' => 'required|string', // bijv. "2-1"
        ]);
    
        // Sla de score op
        $game->uitslag = $request->input('uitslag');
        $game->save();
    
        // Haal teamgegevens op
        $team1 = Team::findOrFail($game->team1_id);
        $team2 = Team::findOrFail($game->team2_id);
    
        // Verwerk de score (bijv. "2-1")
        [$score1, $score2] = explode('-', $game->uitslag);
    
        // Puntenberekening: winst = 3, gelijk = 1, verlies = 0
        if ($score1 > $score2) {
            $team1->points += 3; // Team 1 wint
        } elseif ($score1 < $score2) {
            $team2->points += 3; // Team 2 wint
        } else {
            $team1->points += 1; // Gelijkspel
            $team2->points += 1;
        }
    
        // Sla de nieuwe punten op
        $team1->save();
        $team2->save();
    
        // Redirect met succesbericht
        return redirect()->back()->with('success', 'Uitslag en punten bijgewerkt!');
    }
}
