@extends('layouts.layout')

@section('content')
    <h2>Import to the Dictionary</h2>

    @if(session('success'))
        <h4 style="color:green">{{ session('success') }}</h4>
    @endif
    
    <form action="{{ route('word.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="file">Choose CSV File:</label>
            <input type="file" id="file" name="file" accept=".csv" required>
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Import Words</button>
        </div>
    </form>

    <div style="margin-top: 20px;">
        <h3>CSV Format:</h3>
        <a href="{{ asset('samples/sample_csv_format.csv') }}" download style="color: blue; text-decoration: underline;">
            Download Sample CSV File
        </a>
        <p>Your CSV file should have these columns (first row as headers):</p>
        <code>word,pronunciation,part_of_speech,definition</code>
    </div>
@endsection