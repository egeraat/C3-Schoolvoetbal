<div class="auth-container login-container">
    <form method="POST" action="{{ route('login') }}">
        <link rel="stylesheet" href="{{ asset('app.css') }}">
        @csrf

        <h2>Inloggen</h2>

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

        <button type="submit">Inloggen</button>

        <div class="mt-2">
            <a href="{{ route('register') }}">Registreren?</a>
            <a href="{{ route('password.request') }}" class="text-primary">Wachtwoord vergeten?</a>
        </div>
       
    </form>
</div>
