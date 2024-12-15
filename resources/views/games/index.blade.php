@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wedstrijdschema</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Veld</th>
                <th>Scheidsrechter</th>
                <th>Uitslag</th>
                <th>Starttijd</th>
                <th>Aanpassen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $game->team1->name }}</td>
                <td>{{ $game->team2->name }}</td>
                <td>{{ $game->field ?? 'Niet toegewezen' }}</td>
                <td>{{ $game->scheidsrechter ?? 'Niet toegewezen' }}</td>
                <td>{{ session('uitslag', $game->uitslag) ?? '-' }}</td>
                <td>{{ $game->starttijd ? $game->starttijd->format('H:i') : 'Niet beschikbaar' }}</td>
                <td>
                    <form action="{{ route('games.updateScore', $game->id) }}" method="POST">
                        @csrf
                        <input type="text" name="uitslag" value="{{ old('uitslag', $game->uitslag) }}" class="form-control" placeholder="Score">
                        <button type="submit" class="btn btn-primary btn-sm mt-1">Bijwerken</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Test script -->
<div class="mt-4">
    <h2>Test Score Update After Refresh</h2>
    <button id="refreshButton" class="btn btn-secondary">Refresh Page</button>
    <div id="scoreDisplay" class="mt-2"></div>
</div>

<script>
    document.getElementById('refreshButton').addEventListener('click', function() {
        location.reload(); // Reloads the page
    });

    // Display the score from session storage after a page refresh
    window.onload = function() {
        var uitslag = "{{ session('uitslag', '-') }}";
        document.getElementById('scoreDisplay').textContent = 'Current Score: ' + uitslag;
    };
</script>
@endsection
