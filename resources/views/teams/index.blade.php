{{-- resources/views/teams/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Teams</h1>

    <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Voeg Team Toe</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Aangemaakt door</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->user->name ?? 'Onbekend' }}</td>
                    <td>
                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">Bewerken</a>
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                        </form>
                        <a href="{{ route('teams.team-full-view', $team->id) }}" class="btn btn-info">
                        Bekijk Details
                    </a>

                        @auth
                            @if(auth()->user()->team_id !== $team->id)
                                <form action="{{ route('teams.join', $team->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Voeg mij toe</button>
                                </form>
                            @else
                                <span class="text-success">Je zit al in dit team</span>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
