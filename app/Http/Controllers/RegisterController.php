<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email',
            'password' => 'required|min:6|confirmed',

        ]);
    
        Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => 0, 
            'team_id' => null, 
        ]);
    
        return redirect()->route('login')->with('success', 'Account aangemaakt. Log in om verder te gaan.');
    }
    
}
