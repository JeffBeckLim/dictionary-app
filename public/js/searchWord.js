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

    
    // Click on suggested word → Fetch word details
    $(document).on('click', '.suggested-word , .suggestion-item', function () {
        let wordId = $(this).data('id');
        let word = $(this).text();

        $search.val(word.trim());
        $suggestions.hide().html('');

        $.ajax({
            url: wordDetailRoute.replace(':id', wordId),
            type: "GET",
            success: function (word) {
                $wordDetails.html(`
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-6">
                            <div class="card border-success shadow-sm position-relative" style="background-color:#E2FED6;">
                                
                                <!-- Close Button -->
                                <button type="button"
                                        class="btn-close position-absolute top-0 end-0 m-3 fs-6"
                                        aria-label="Close"
                                        id="close-word-details">
                                </button>
                                
                                <div class="card-body">
                                    <h5 class="card-title text-success">
                                        <span class="fw-bold fs-2">${word.word}</span>
                                        ${word.pronunciation ? `<small class="text-muted">(${word.pronunciation})</small>` : ''}
                                        ${word.recording_path ? 
                                            `
                                                <button
                                                id="play-pronunciation"
                                                data-audio="${word.recording_path} "
                                                title="Play Pronunciation"
                                                style="background: none; border: none; color: #198754; font-size: 1.2rem; cursor: pointer;"
                                                >
                                                    🔈
                                                </button>
                                            ` : 
                                            '<small class="text-muted">🔇</small>'}
                                        
                                    </h5>
                                    <p class="card-text">${word.definition}</p>
                                    <span class="badge bg-success-subtle text-success fw-semibold text-capitalize">
                                        ${word.part_of_speech}
                                    </span>
                                    <br/>
                                    <small class="mt-2 mb-0 text-muted">Added by: <strong>${word.user ? word.user.name : 'Unknown'}</strong></small>
                                    <br/>
                                    <small class="mt-2 mb-0 text-muted">Last updated: <strong>${new Date(word.updated_at).toLocaleDateString('en-US', { dateStyle: 'medium' })}</strong></small>
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

    // Handle close button for word detail card
    $(document).on('click', '#close-word-details', function () {
        $('#word-details').empty();
    });



    // Hide suggestions when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search, #suggestions').length) {
            $suggestions.hide();
        }
    });
});

// Play pronunciation audio
$(document).on('click', '#play-pronunciation', function () {
    const audioPath = $(this).data('audio');

    const $btn = $(this);

    $btn.text('🔊');
    
    console.log('Audio Path:', audioPath); 
    if (audioPath) {
        playAudio(audioPath, $btn);
    } else {
        alert('No audio available for this word.');
    }

});

function playAudio(audioPath, btn){
    let audio = new Audio(audioPath);
    audio.play();

     audio.addEventListener('ended', () => {
       console.log('Audio playback ended');
       btn.text('🔈');
    });
}
