{{-- 

Master Layout 

--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ ucfirst(str_replace('-', ' ', Route::currentRouteName())) ?? config('app.name', 'Aklanon Fishing Terms') }}
    </title>


    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Bundle (includes Popper for dropdowns) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Optional Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fff4;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
                🦈  Aklanon Fishing Terms
            </a>

            {{-- Hamburger Button --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Collapsible Menu --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contribute') }}">Contribute</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('import') }}">Import</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manage') }}">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">+ Account</a>
                    </li>
                    @auth
                        <li class="nav-item d-flex align-items-center">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success">Logout</button>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-success ">Login</a>
                        </li>
                    @endguest


                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content Area --}}
    <main class="container my-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center text-success py-3 mt-auto">
        <small>&copy; {{ date('Y') }} Aklanon Dictionary. All rights reserved.</small>
    </footer>

</body>
</html>