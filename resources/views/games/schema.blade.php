@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h1 class="text-primary">Wedstrijdschema</h1>
            <p>Hier is het wedstrijdschema voor je:</p>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $game->team1->name }}</td>
                            <td>{{ $game->team2->name }}</td>
                            <td>{{ $game->field ?? 'Niet toegewezen' }}</td>
                            <td>{{ $game->scheidsrechter ?? 'Niet toegewezen' }}</td>
                            <td>{{ $game->uitslag ?? '-' }}</td>
                            <td>{{ $game->starttijd ? $game->starttijd->format('H:i') : 'Niet beschikbaar' }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
