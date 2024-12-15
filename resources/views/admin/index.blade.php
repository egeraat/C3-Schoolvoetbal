@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gebruikersbeheer</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.update') }}" method="POST">
        @csrf
        @method('PUT') <!-- Zorg ervoor dat je de juiste method gebruikt -->
        
        <div class="form-group">
            <label for="user_id">Kies een gebruiker</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">Selecteer een gebruiker</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option> <!-- Zorg ervoor dat 'name' bestaat in je User model -->
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Markeer als admin</button>
    </form>

</div>
@endsection
