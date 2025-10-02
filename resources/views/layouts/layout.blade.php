{{-- 

Master Layout 

--}}
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Dictionay App') }}</title>

        {{-- jquery --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Aklanon Dictionary</h1>
    
    @if (Auth::check())
        <p>Logged in User: {{ Auth::user()->email }}</p>
    @endif
    
    <a href="{{ route('home') }}">Home</a> |
    <a href="{{ route('contribute') }}">Contribute</a> | 
    <a href="{{ route('import') }}">Import</a>
    
    @yield('content')
</body>
</html>