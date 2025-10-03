@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Forgot Your Password?</h2>
        <p class="text-muted">
            No problem. Just enter your email address below and we'll send you a link to reset your password.
        </p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="border p-4 rounded shadow-sm">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label text-success">{{ __('Email') }}</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control border-success @error('email') is-invalid @enderror"
                       required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>

@endsection
