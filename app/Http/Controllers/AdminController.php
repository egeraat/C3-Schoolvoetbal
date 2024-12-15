<?php

namespace App\Http\Controllers;

use App\Models\Player; // Aangezien je 'Player' gebruikt, neem ik aan dat dit je gebruikersmodel is
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Haal alle gebruikers op uit de 'users' tabel
        return view('admin.index', compact('users')); // Verzend naar de view
    }


public function show()
{
    $users = User::where('is_admin', false)->get(); 
    return view('admin.update', compact('users'));
}
public function store(Request $request)
{
    // Valideer de binnenkomende gegevens
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id', // Zorg ervoor dat de geselecteerde gebruiker bestaat
    ]);

    // Haal de geselecteerde gebruiker op
    $user = User::find($request->input('user_id'));

    // Hier kun je de bewerking uitvoeren, bijvoorbeeld het bijwerken van een veld
    // Bijvoorbeeld, het instellen van de gebruiker als admin:
    $user->is_admin = true; // Of een andere logica die je nodig hebt
    $user->save();

    // Redirect of geef een succesvolle melding
    return redirect()->route('admin.index')->with('success', 'Gebruiker is bijgewerkt!');
}

public function update(Request $request)
{
    // Validatie
    $request->validate([
        'user_id' => 'required|exists:users,id', // Zorg ervoor dat de geselecteerde gebruiker bestaat
    ]);

    // Haal de geselecteerde gebruiker op
    $user = User::findOrFail($request->user_id);

    // Zet de gebruiker als admin
    $user->is_admin = true;
    $user->save();

    // Redirect of geef een succesvolle melding
    return redirect()->route('admin.index')->with('success', 'Gebruiker is nu admin!');
}

// Verwijderen van een gebruiker
public function destroy($id)
{
    $user = User::findOrFail($id); // Zorg ervoor dat het het juiste model is
    $user->delete();

    return redirect()->route('admin.index')->with('success', 'Gebruiker succesvol verwijderd.');
}
}
