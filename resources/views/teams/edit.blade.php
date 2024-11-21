@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Team Bewerken: {{ $team->name }}</h1>

    <form action="{{ route('teams.update', $team->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Team Naam</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Werk Team Bij</button>
    </form>

    <hr>

    <h3>Spelers in dit Team</h3>
    <ul>
        @foreach($team->players as $player)
            <li>{{ $player->name }}</li>
        @endforeach
    </ul>

    <form action="{{ route('teams.addPlayer', $team->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Naam van de speler</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Voeg Speler Toe</button>
    </form>
</div>
@endsection
