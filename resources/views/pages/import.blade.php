@extends('layouts.layout')

@section('content')
    <div class="card shadow-sm border-success mb-5">
        <div class="card-body">
            <h2 class="card-title fw-bold text-success">Import to the Dictionary</h2>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('word.import.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="file" class="form-label">Choose CSV File</label>
                    <input type="file" id="file" name="file" class="form-control border-success" accept=".csv" required>
                </div>

                <button type="submit" class="btn btn-success">Import Words</button>
            </form>

            <div class="mt-4">
                <h5>CSV Format</h5>
                <a href="{{ asset('samples/sample_csv_format.csv') }}" class="link-success" download>
                    Download Sample CSV File
                </a>
                <p class="mt-2 text-muted">Your CSV file should have these columns:</p>
                <code>word,pronunciation,part_of_speech,definition</code>
            </div>
        </div>
    </div>
@endsection
