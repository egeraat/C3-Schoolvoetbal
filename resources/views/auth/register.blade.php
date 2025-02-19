<div class="auth-container register-container">
    <form method="POST" action="{{ route('register') }}">
        <link rel="stylesheet" href="{{ asset('app.css') }}">
        @csrf

        <h2>Registreren</h2>

        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="email">E-mailadres</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Wachtwoord</label>
        <input id="password" type="password" name="password" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Wachtwoord bevestigen</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">Registreren</button>
    </form>
</div>
