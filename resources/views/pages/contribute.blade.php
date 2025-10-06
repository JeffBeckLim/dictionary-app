@extends('layouts.layout')

@section('content')
    <div class="card shadow-sm border-success mb-5">
        <div class="card-body">
            <h2 class="card-title fw-bold text-success">Contribute a New Word</h2>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('word.store') }}" method="POST" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="word" class="form-label">Word</label>
                    <input type="text" id="word" name="word" class="form-control border-success" required placeholder="e.g., aesthetic">
                </div>

                <div class="mb-3">
                    <label for="pronunciation" class="form-label">Pronunciation</label>
                    <input type="text" id="pronunciation" name="pronunciation" class="form-control border-success" placeholder="/es.ˈθe.tɪk/">
                </div>

                <div class="mb-3">
                    <label for="part_of_speech" class="form-label">Part of Speech</label>
                    <select id="part_of_speech" name="part_of_speech" class="form-select border-success">
                        <option value="">Select...</option>
                        <option value="noun">Noun</option>
                        <option value="verb">Verb</option>
                        <option value="adjective">Adjective</option>
                        <option value="adverb">Adverb</option>
                        <option value="pronoun">Pronoun</option>
                        <option value="preposition">Preposition</option>
                        <option value="conjunction">Conjunction</option>
                        <option value="interjection">Interjection</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="definition" class="form-label">Definition</label>
                    <textarea id="definition" name="definition" rows="4" class="form-control border-success"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Submit Word</button>
            </form>
        </div>
    </div>
@endsection
