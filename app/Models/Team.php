<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function user()
{
    return $this->belongsTo(User::class); // Aangemaakt door één gebruiker
}

public function users()
{
    return $this->belongsToMany(User::class); // Meerdere spelers
}
}
