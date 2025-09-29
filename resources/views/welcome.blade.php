<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Dictionay App') }}</title>

    </head>
    <body>
       <h1>Welcome to Stunna Dictionary</h1>

       <script>
        console.log(@json($words));
       </script>

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
