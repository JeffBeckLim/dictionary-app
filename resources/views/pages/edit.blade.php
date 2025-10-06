@extends('layouts.layout')

@section('content')
    <div class="card shadow-sm border-success">
        <div class="card-body">
            <h2 class="card-title fw-bold text-success mb-4">Edit Word</h2>

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('word.update', $word->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="word" class="form-label">Word <span class="text-danger">*</span></label>
                    <input type="text" name="word" id="word" class="form-control" value="{{ old('word', $word->word) }}" required>
                </div>

                <div class="mb-3">
                    <label for="pronunciation" class="form-label">Pronunciation</label>
                    <input type="text" name="pronunciation" id="pronunciation" class="form-control" value="{{ old('pronunciation', $word->pronunciation) }}">
                </div>

                <div class="mb-3">
                    <label for="part_of_speech" class="form-label">Part of Speech</label>
                    <input type="text" name="part_of_speech" id="part_of_speech" class="form-control" value="{{ old('part_of_speech', $word->part_of_speech) }}">
                </div>

                <div class="mb-3">
                    <label for="definition" class="form-label">Definition</label>
                    <textarea name="definition" id="definition" class="form-control" rows="4">{{ old('definition', $word->definition) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Word</button>
                <a href="{{ route('manage') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection
