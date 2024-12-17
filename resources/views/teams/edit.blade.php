@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Team bewerken</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teams.update', $team->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Teamnaam</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $team->name) }}" required>
            </div>

            @auth
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                    <a href="{{ route('teams.index') }}" class="btn btn-secondary">Annuleren</a>
                </div>
            @endauth
        </form>

        <hr>
        <h3>Spelers in dit Team</h3>
        <ul>
            @foreach($team->users as $user)
                <li>{{ $user->name }}</li>
            @endforeach
        </ul>

    
    </div>
@endsection
