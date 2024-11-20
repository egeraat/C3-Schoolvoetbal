@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>DASHBOARD</h1>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Home</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Teams</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="speelschemaDropdown" role="button" data-toggle="dropdown">
                                Speelschema
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Schema</a>
                                <a class="dropdown-item" href="#">Genereren</a>
                                <a class="dropdown-item" href="#">Scores</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-md-4">
            <h4>Schoolvoetbal</h4>
            <h5>Top 5:</h5>
            <ul>
                <li>1. ---</li>
                <li>2. ---</li>
                <li>3. ---</li>
                <li>4. ---</li>
                <li>5. ---</li>
            </ul>
        </div>


        <div class="col-md-4">
            <div class="border bg-light" style="height: 230px; display: flex; justify-content: center; align-items: center;">

                <img src="{{ asset('voetbalveld.jpg') }}" alt="Voorbeeld Afbeelding" style="max-height: 100%; max-width: 100%;">
            </div>
        </div>


        <div class="col-md-4">
            <h5>Mijn team:</h5>
            <ul>
                <li>Speler 1</li>
                <li>Speler 2</li>
                <li>Speler 3</li>
                <li>Speler 4</li>
            </ul>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-12 text-center">
            <a href="#" class="btn btn-primary">
                Naar het wedstrijdschema →
            </a>
        </div>
    </div>
</div>
@endsection
