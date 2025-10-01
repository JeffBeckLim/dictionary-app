@extends('layouts.layout')

@section('content')
    <h2>Contribute to the Dictionary</h2>    

    @if(session('success'))
        <h4 style="color:green">{{ session('success') }}</h4>
    @endif

    <form action="{{ route('word.store') }}" method="POST">
    @csrf
    
    <div>
        <label for="word">Word:</label>
        <input type="text" id="word" name="word" required>
    </div>

    <div>
        <label for="pronunciation">Pronunciation:</label>
        <input type="text" id="pronunciation" name="pronunciation" placeholder="e.g., /wɜːrd/">
    </div>

    <div>
        <label for="part_of_speech">Part of Speech:</label>
        <select id="part_of_speech" name="part_of_speech">
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

    <div>
        <label for="definition">Definition:</label>
        <textarea id="definition" name="definition" rows="4"></textarea>
    </div>

    <div>
        <button type="submit">Submit Word</button>
    </div>
</form>
@endsection