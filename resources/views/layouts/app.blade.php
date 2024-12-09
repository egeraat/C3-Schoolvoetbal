<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Voeg Bootstrap toe -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Voeg je eigen CSS toe -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-success shadow-sm">
            <a class="navbar-brand text-white" href="{{ route('dashboard') }}">Schoolvoetbal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('teams.index') }}">Teams</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="speelschemaDropdown" role="button" data-toggle="dropdown">
                            Speelschema
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Schema</a>
                            <a class="dropdown-item" href="#">Genereren</a>
                            <a class="dropdown-item" href="#">Scores</a>
                        </div>
                    </li>
                </ul>

                <!-- User info and logout -->
                <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-white">Ingelogd als: {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
        
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
