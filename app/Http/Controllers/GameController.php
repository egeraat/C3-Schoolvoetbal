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
        if ($team->user_id !== auth()->id() && auth()->user()->email !== 'admin@example.com') {
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
    
}
