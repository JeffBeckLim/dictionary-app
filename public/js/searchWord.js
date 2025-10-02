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
            success: function (word) {
                $('#word-details').html(`
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-6">
                            <div class="card border-success shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-success">
                                        ${word.word}
                                        ${word.pronunciation ? `<small class="text-muted">(${word.pronunciation})</small>` : ''}
                                    </h5>
                                    <p class="card-text">${word.definition}</p>
                                    <span class="badge bg-success-subtle text-success fw-semibold text-capitalize">
                                        ${word.part_of_speech}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }
        });
    });
    
});
