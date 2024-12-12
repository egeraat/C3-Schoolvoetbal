<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    // Vulbare velden (we laten email en password weg)
    protected $fillable = [
        'name', 
        'team_id', 
    ];

    // Relatie met het Team-model (elke speler behoort tot één team)
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
