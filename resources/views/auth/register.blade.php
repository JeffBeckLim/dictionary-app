@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Create Account</h2>
        <p class="text-muted">Join us by filling out the form below</p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <form method="POST" action="{{ route('register') }}" class="border p-4 rounded shadow-sm">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label text-success">{{ __('Name') }}</label>
                <input type="text"
                       class="form-control border-success @error('name') is-invalid @enderror"
                       id="name" name="name"
                       value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label text-success">{{ __('Email') }}</label>
                <input type="email"
                       class="form-control border-success @error('email') is-invalid @enderror"
                       id="email" name="email"
                       value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label text-success">{{ __('Password') }}</label>
                <input type="password"
                       class="form-control border-success @error('password') is-invalid @enderror"
                       id="password" name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-success">{{ __('Confirm Password') }}</label>
                <input type="password"
                       class="form-control border-success"
                       id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>

            {{-- Submit Button --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
@endsection
