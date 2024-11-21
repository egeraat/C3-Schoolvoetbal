<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // Vulbare velden
    protected $fillable = ['name'];

    // Relatie met het Player-model (een team heeft veel spelers)
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
