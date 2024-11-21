@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nieuw Team Toevoegen</h1>

    <form action="{{ route('teams.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Naam van het Team</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Voeg Team Toe</button>
    </form>
</div>
@endsection
