@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wedstrijdschema</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ route('games.generate') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="fields">Aantal velden:</label>
            <select name="fields" id="fields" class="form-control" required>
                <option value="1">1 veld</option>
                <option value="2">2 velden</option>
                <option value="3">3 velden</option>
                <option value="4">4 velden</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Wedstrijdschema Genereren</button>
    </form>
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
                        
                        @if ($errors->has('uitslag'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('uitslag') }}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary btn-sm mt-1">Bijwerken</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
