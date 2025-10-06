@extends('layouts.layout')

@section('content')
    <div class="card shadow-sm border-success">
        <div class="card-body">
            <h2 class="card-title fw-bold text-success">Manage Words</h2>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            {{-- Search form --}}
            <form method="GET" action="{{ route('manage') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search words..." value="{{ $search }}">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </form>

            {{-- Add / Import Buttons --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('import') }}" class="btn btn-outline-success me-2">CSV Import</a>
                <a href="{{ route('contribute') }}" class="btn btn-success">Add New Word</a>
            </div>

            @if($words->isEmpty())
                <p class="text-muted">No words found. Start by adding a new word.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Word</th>
                            <th>Pronunciation</th>
                            <th>Part of Speech</th>
                            <th>Definition</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($words as $word)
                            <tr>
                                <td>{{ $word->word }}</td>
                                <td>{{ $word->pronunciation ?? '-' }}</td>
                                <td class="text-capitalize">{{ $word->part_of_speech }}</td>
                                <td>{{ Str::limit($word->definition, 100) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('word.edit', $word->id) }}" class="btn btn-sm btn-success mb-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $words->links() }}
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

@endsection
