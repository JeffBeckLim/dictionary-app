$(document).ready(function(){
    $('#search').on('keyup', function(){
        let query = $(this).val();
        if(query.length > 1){
            $.ajax({
                url: searchRoute,
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
            url: wordDetailRoute.replace(':id', wordId),
            type: "GET",
            success: function(word){

                console.log(word)

                  let audioHtml = '';
            if(word.recording_path){
                audioHtml = '<button onclick="playAudio(\'/storage/' + word.recording_path + '\')">▶ Play Pronunciation</button>';
            }
                $('#word-details').html(
                    "<p><strong>ID:</strong> " + word.id + "</p>" +
                    "<p><strong>Name:</strong> " + word.word + "</p>" +
                    "<p><strong>Email:</strong> " + word.definition + "</p>"+
                    (word.recording_path ? "<p><strong>Audio:</strong> " + audioHtml + "</p>" : "")
                );
            }
        });
    });
    
});

function playAudio(audioPath){
    let audio = new Audio(audioPath);
    audio.play();
}
