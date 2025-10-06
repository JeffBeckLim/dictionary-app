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

<!-- Global Reusable Confirmation Modal -->
<div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-labelledby="globalConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="globalConfirmModalLabel">Confirm Action</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="globalConfirmMessage">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="globalConfirmYesBtn" type="button" class="btn btn-success">Yes</button>
      </div>
    </div>
  </div>
</div>

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
                        <a class="nav-link {{ Route::is('home') ? 'fw-bold text-success' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('contribute') ? 'fw-bold text-success' : '' }}" href="{{ route('contribute') }}">Contribute</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('import') ? 'fw-bold text-success' : '' }}" href="{{ route('import') }}">Import</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('manage') ? 'fw-bold text-success' : '' }}" href="{{ route('manage') }}">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('register') ? 'fw-bold text-success' : '' }}" href="{{ route('register') }}">Accounts</a>
                    </li>
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
<script>
    function showConfirmationModal({ 
        title = 'Confirm Action', 
        message = 'Are you sure?', 
        confirmButtonText = 'Yes', 
        onConfirm = () => {}
    }) {
        const modal = new bootstrap.Modal(document.getElementById('globalConfirmModal'));
        document.getElementById('globalConfirmModalLabel').innerText = title;
        document.getElementById('globalConfirmMessage').innerText = message;
        document.getElementById('globalConfirmYesBtn').innerText = confirmButtonText;

        const confirmBtn = document.getElementById('globalConfirmYesBtn');

        // Remove previous click handlers
        const newButton = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newButton, confirmBtn);

        newButton.addEventListener('click', () => {
            modal.hide();
            onConfirm(); // execute passed callback
        });

        modal.show();
    }
</script>

</html>