<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Dictionay App') }}</title>

    </head>
    <body>
       <h1>Aklan Dictionary</h1>


       <input type="text" id="search" placeholder="Search..." autocomplete="off">
       
       <div style="border: 1px solid black; max-width: 150px;" id="suggestions"></div>
       <div id="word-details"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    {{-- public/js/searchWord.js --}}
    <script>
        // Pass routes into JavaScript variables
        const searchRoute = "{{ route('search') }}";
        const wordDetailRoute = "{{ route('word.details', ':id') }}"; // placeholder
    </script>
    {{-- JS CODE FOR SEARCH --}}
    <script src="{{ asset('js/searchWord.js') }}"></script>

    {{-- Display Words from DB --}}

    <h4>Words in Database:</h4>
    <ul>
        @foreach($words as $word)
            <li>
                <strong>{{ $word->word }}</strong>
                @if($word->pronunciation)
                    ({{ $word->pronunciation }})
                @endif
                <br>
                {{ $word->definition }}
                <br>
                <em>{{ $word->part_of_speech }}</em>
            </li>
        @endforeach
    </ul>

    </body>
</html>
