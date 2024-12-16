@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ranglijst</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Team</th>
                <th>Punten</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $index => $team)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- Positie -->
                <td>{{ $team->name }}</td>
                <td>{{ $team->points }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
