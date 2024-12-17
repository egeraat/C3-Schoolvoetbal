@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Team: {{ $team->name }}</h1>
    <p>Aangemaakt door: {{ $team->user->name ?? 'Onbekend' }}</p>

    <h3>Spelers:</h3>
    <ul>
        @forelse($team->users as $player)
            <li>{{ $player->name }}</li>
        @empty
            <li>Geen spelers toegevoegd</li>
        @endforelse
    </ul>

    <a href="{{ route('teams.index') }}" class="btn btn-secondary mt-3">Terug naar Teams</a>
</div>
@endsection
