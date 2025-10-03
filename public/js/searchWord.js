$(document).ready(function () {
    const $search = $('#search');
    const $suggestions = $('#suggestions');
    const $wordDetails = $('#word-details');

    // Trigger search on keyup
    $search.on('keyup', function () {
        let query = $(this).val().trim();

        if (query.length > 1) {
            $.ajax({
                url: searchRoute,
                type: "GET",
                data: { query: query },
                success: function (data) {
                    if (data.length > 0) {
                        let suggestions = '';

                        data.forEach(item => {
                            suggestions += `
                                <button type="button" class="dropdown-item suggestion-item text-start" data-id="${item.id}">
                                    ${item.word}
                                </button>
                            `;
                        });

                        $suggestions
                            .html(suggestions)
                            .show();
                    } else {
                        $suggestions
                            .html('<span class="dropdown-item text-muted disabled">No matches found</span>')
                            .show();
                    }
                },
                error: function () {
                    $suggestions
                        .html('<span class="dropdown-item text-danger disabled">Error fetching suggestions</span>')
                        .show();
                }
            });
        } else {
            $suggestions.hide().html('');
        }
    });

    // Click suggestion → Fetch word details
    $(document).on('click', '.suggestion-item', function () {
        let wordId = $(this).data('id');
        let word = $(this).text();

        $search.val(word);
        $suggestions.hide().html('');

        $.ajax({
            url: wordDetailRoute.replace(':id', wordId),
            type: "GET",
            success: function (word) {
                $wordDetails.html(`
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-6">
                            <div class="card border-success shadow-sm" style="background-color:#E2FED6;">
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
            },
            error: function () {
                $wordDetails.html('<p class="text-danger">Failed to load word details.</p>');
            }
        });
    });

    // Click on suggested word → Fetch word details
    $(document).on('click', '.suggested-word', function () {
        let wordId = $(this).data('id');
        let word = $(this).text();

        $search.val(word);
        $suggestions.hide().html('');

        $.ajax({
            url: wordDetailRoute.replace(':id', wordId),
            type: "GET",
            success: function (word) {
                $wordDetails.html(`
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-6">
                            <div class="card border-success shadow-sm" style="background-color:#E2FED6;">
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
            },
            error: function () {
                $wordDetails.html('<p class="text-danger">Failed to load word details.</p>');
            }
        });
    });


    // Hide suggestions when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search, #suggestions').length) {
            $suggestions.hide();
        }
    });
});

function playAudio(audioPath){
    let audio = new Audio(audioPath);
    audio.play();
}
