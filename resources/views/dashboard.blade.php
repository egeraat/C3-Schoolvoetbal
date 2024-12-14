@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="text-center text-primary font-weight-bold">C3-SCHOOLVOETBAL</h1>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <h4 class="card-header text-center text-success">Schoolvoetbal</h4>
                <div class="card-body">
                    <h5 class="card-title">Top 5:</h5>
                    <ul class="list-unstyled">
                        <li>1. Team A</li>
                        <li>2. Team B</li>
                        <li>3. Team C</li>
                        <li>4. Team D</li>
                        <li>5. Team E</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ asset('voetbalveld.jpg') }}" alt="Voorbeeld Afbeelding" class="card-img-top">
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <h5 class="card-header text-center text-primary">Mijn team</h5>
                <div class="card-body">
                    @if($team)
                        <h5 class="card-title">Spelers in jouw team:</h5>
                        <ul class="list-unstyled">
                            @foreach($players as $player)
                                <li>{{ $player->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Je zit niet in een team. Voeg jezelf toe aan een team om spelers te zien.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
    <div class="col-12 text-center">
        @if (auth()->user()->email === 'admin@example.com')
            <form action="{{ route('games.generate') }}" method="POST">
                @csrf
                <input type="hidden" name="fields" value="4">
                <button type="submit" class="btn btn-primary">Wedstrijdschema Genereren</button>
            </form>
        @else
            <input type="hidden" name="fields" value="4">
            <a href="{{ route('games.view') }}" class="btn btn-primary">Bekijk Wedstrijdschema</a>
        @endif
    </div>
</div>


    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('teams.index') }}" class="btn btn-primary btn-lg shadow-sm">Naar de Teams →</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-success text-white text-center py-3">
    <p class="footer-text">© 2024 Schoolvoetbal Toernooi</p>
</footer>
@endsection
