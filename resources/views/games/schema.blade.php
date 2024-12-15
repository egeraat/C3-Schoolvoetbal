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
                        <th>Acties</th>
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
                            <td>
                                @if(auth()->user()->isAdmin())
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUitslagModal" data-game-id="{{ $game->id }}" data-team1="{{ $game->team1->name }}" data-team2="{{ $game->team2->name }}">
                                        Bewerk uitslag
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modaal voor uitslag bewerken -->
<div class="modal fade" id="editUitslagModal" tabindex="-1" aria-labelledby="editUitslagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUitslagModalLabel">Bewerk uitslag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('games.updateUitslag') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="game_id" id="modalGameId">
                    <div class="mb-3">
                        <label for="team1Score" class="form-label">Score {{ '{{' }} team1Name }}</label>
                        <input type="number" class="form-control" id="team1Score" name="team1_score" required>
                    </div>
                    <div class="mb-3">
                        <label for="team2Score" class="form-label">Score {{ '{{' }} team2Name }}</label>
                        <input type="number" class="form-control" id="team2Score" name="team2_score" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Vul modaal met gegevens
    const editUitslagModal = document.getElementById('editUitslagModal');
    editUitslagModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const gameId = button.getAttribute('data-game-id');
        const team1Name = button.getAttribute('data-team1');
        const team2Name = button.getAttribute('data-team2');

        document.getElementById('modalGameId').value = gameId;
        document.querySelector('[for="team1Score"]').textContent = `Score ${team1Name}`;
        document.querySelector('[for="team2Score"]').textContent = `Score ${team2Name}`;
    });
</script>
@endsection
