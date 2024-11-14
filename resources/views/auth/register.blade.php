<form method="POST" action="{{ route('register') }}">
<link rel="stylesheet" href="{{ asset('app.css') }}">
    @csrf

    <h2>Registreren</h2>
    
    <label for="name">Naam</label>
    <input id="name" type="text" name="name" required autofocus>
    
    <label for="email">E-mailadres</label>
    <input id="email" type="email" name="email" required>
    
    <label for="password">Wachtwoord</label>
    <input id="password" type="password" name="password" required>
    
    <label for="password_confirmation">Wachtwoord check</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>
    
    <button type="submit">Registreren</button>
</form>
