@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Confirm Password</h2>
        <p class="text-muted">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <form method="POST" action="{{ route('password.confirm') }}" class="border p-4 rounded shadow-sm">
            @csrf

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label text-success">{{ __('Password') }}</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control border-success @error('password') is-invalid @enderror"
                       required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
    
@endsection
