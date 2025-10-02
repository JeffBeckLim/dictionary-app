@extends('layouts.layout')

@section('content')

    {{-- Page Heading --}}
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">What Word Piques Your Interest?</h2>

        {{-- Search Box --}}
        <div class="input-group mt-4 mx-auto" style="max-width: 500px;">
            <input type="text" id="search" class="form-control border-success" placeholder="Search..." autocomplete="off">
            <button class="btn btn-success" type="button">Search</button>
        </div>

        {{-- Suggested Words --}}
        @if(!empty($suggestedWords) && count($suggestedWords) > 0)
            <div class="form-text text-success mt-2">
                Suggested:
                @foreach($suggestedWords as $suggested)
                    <span class="badge bg-success-subtle text-success me-1">{{ $suggested->word }}</span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Suggestions (from search) --}}
    <div id="suggestions" class="list-group mx-auto mb-4" style="max-width: 500px; display: none;"></div>

    {{-- Word Details loaded via AJAX --}}
    <div id="word-details" class="mt-5"></div>

    {{-- Word List from DB --}}
    <h3 class="fw-bold text-success mt-5 mb-3">Words in Database</h3>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($words as $word)
            <div class="col">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-success">{{ $word->word }}
                            @if($word->pronunciation)
                                <small class="text-muted">({{ $word->pronunciation }})</small>
                            @endif
                        </h5>
                        <p class="card-text">{{ $word->definition }}</p>
                        <span class="badge bg-success-subtle text-success fw-semibold text-capitalize">{{ $word->part_of_speech }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- JavaScript Integration --}}
    <script>
        const searchRoute = "{{ route('search') }}";
        const wordDetailRoute = "{{ route('word.details', ':id') }}";
    </script>
    <script src="{{ asset('js/searchWord.js') }}"></script>

@endsection
