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
    <script>
    $(document).ready(function(){
        $('#search').on('keyup', function(){
            let query = $(this).val();
            if(query.length > 1){
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data){
                        let suggestions = '';
                        data.forEach(item => {
                            console.log(item)
                            suggestions += '<div class="suggestion-item" data-id="'+item.id+'">'+item.word+'</div>';
                        });
                        $('#suggestions').html(suggestions);
                    }
                });
            } else {
                $('#suggestions').html('');
            }
        });

        // Click suggestion -> Display Word Details
        $(document).on('click', '.suggestion-item', function(){
            let wordId = $(this).data('id');
            let word = $(this).text();

            $('#search').val(word);
            $('#suggestions').html('');

            // Fetch word  details
            $.ajax({
                url: "/word/" + wordId,
                type: "GET",
                success: function(word){

                    console.log(word)
                    $('#word-details').html(
                        "<p><strong>ID:</strong> " + word.id + "</p>" +
                        "<p><strong>Name:</strong> " + word.word + "</p>" +
                        "<p><strong>Email:</strong> " + word.definition + "</p>"
                    );
                }
            });
        });
        
    });
    </script>


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
