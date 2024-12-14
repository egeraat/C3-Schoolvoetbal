@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wedstrijdschema</h1>
    
    <!-- Bericht als het schema succesvol is gegenereerd -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Knop om het schema te genereren -->
    <form action="{{ route('games.generate') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Wedstrijdschema Genereren</button>
    </form>

    <!-- Tabel met wedstrijden -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Scheidsrechter</th>
                <th>Uitslag</th>
                <th>Starttijd</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
            <tr>
                <td>{{ $game->id }}</td>
                <td>{{ $game->team1->name }}</td>
                <td>{{ $game->team2->name }}</td>
                <td>{{ $game->scheidsrechter }}</td>
                <td>{{ $game->starttijd ? $game->starttijd->format('H:i') : 'Tijd niet beschikbaar' }}</td>
                <td>{{ $game->starttijd ? $game->starttijd->format('H:i') : 'Tijd niet beschikbaar' }}</td>
            </tr>
            @endforeach
    </tbody>
    </table>
</div>
@endsection
