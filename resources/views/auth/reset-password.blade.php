@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Reset Your Password</h2>
        <p class="text-muted">Enter your email and new password below.</p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <form method="POST" action="{{ route('password.store') }}" class="border p-4 rounded shadow-sm">
            @csrf

            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label text-success">{{ __('Email') }}</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $request->email) }}"
                       class="form-control border-success @error('email') is-invalid @enderror"
                       required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label text-success">{{ __('Password') }}</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control border-success @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-success">{{ __('Confirm Password') }}</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control border-success @error('password_confirmation') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>

@endsection
