@extends('layouts.layout')

@section('content')
    <div class="card shadow-sm border-success">
        <div class="card-body">
            <h2 class="card-title fw-bold text-success">Manage Words</h2>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            {{-- Search form --}}
            <form method="GET" action="{{ route('manage') }}" class="mb-3 position-relative">
                <div class="input-group">
                    <input type="text" id="search-input" name="search" class="form-control" placeholder="Search words..." value="{{ $search }}">
                    @if(request('search'))
                        <a href="{{ route('manage') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>

                {{-- Suggestions dropdown --}}
                <div id="search-suggestions" class="dropdown-menu w-100 shadow-sm" style="position: absolute; top: 100%; z-index: 1000; display: none;"></div>
            </form>

            {{-- Add / Import Buttons --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('import') }}" class="btn btn-outline-success me-2">CSV Import</a>
                <a href="{{ route('contribute') }}" class="btn btn-success">Add New Word</a>
            </div>

            @if($words->isEmpty())
                <p class="text-muted">No words found. Start by adding a new word.</p>
            @else
            <div class="table-responsive"> 
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Word</th>
                            <th>Pronunciation</th>
                            <th>Part of Speech</th>
                            <th>Definition</th>
                            <th>Audio</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($words as $word)
                            <tr>
                                <td>{{ $word->word }}</td>
                                <td>\ {{ $word->pronunciation ?? '-' }} \</td>
                                <td class="text-capitalize">{{ $word->part_of_speech }}</td>
                                <td>{{ Str::limit($word->definition, 100) }}</td>
                                 <td>
                                    @if($word->recording_path)
                                        <audio controls style="width: 100px;">
                                            <source src="{{ asset('storage/' . $word->recording_path) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @else
                                        <span class="text-muted">No audio</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <a href="{{ route('word.edit', $word->id) }}" class="btn btn-sm btn-success mb-1">Edit Word</a>
                                    
                                    <a href="{{ route('audio', $word->id) }}" class="btn btn-sm btn-outline-success mb-1">
                                        {{ $word->recording_path ? 'Update Recording' : 'Add Recording' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $words->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
    <style>
    .pagination .page-link {
        color: #198754; 
        border-color: #198754;
    }
    .pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }
    .pagination .page-link:hover {
        color: white;
        background-color: #198754;
        border-color: #198754;
    }
    </style>
    
    <script>
        const input = document.getElementById('search-input');
        const suggestionsBox = document.getElementById('search-suggestions');

        input.addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length < 2) {
                suggestionsBox.style.display = 'none';
                return;
            }

            fetch(`{{ route('manage.suggest') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (Object.keys(data).length) {
                        for (const [id, word] of Object.entries(data)) {
                            const item = document.createElement('a');
                            item.href = `?search=${encodeURIComponent(word)}`;
                            item.className = 'dropdown-item';
                            item.textContent = word;
                            suggestionsBox.appendChild(item);
                        }
                        suggestionsBox.style.display = 'block';
                    } else {
                        suggestionsBox.style.display = 'none';
                    }
                });
        });

        // Hide suggestions if clicking outside
        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    </script>

@endsection
