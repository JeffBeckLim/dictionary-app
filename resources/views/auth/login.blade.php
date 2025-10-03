@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Welcome Back!</h2>
        <p class="text-muted">Please log in to continue</p>
    </div>

    <div class="mx-auto" style="max-width: 400px;">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="border p-4 rounded shadow-sm">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label text-success">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control border-success @error('email') is-invalid @enderror"
                       required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label text-success">{{ __('Password') }}</label>
                <input id="password" type="password" name="password"
                       class="form-control border-success @error('password') is-invalid @enderror"
                       required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-3">
                <input class="form-check-input border-success" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label text-success" for="remember_me">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Submit & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-success">
                    {{ __('Log in') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="text-decoration-underline text-success" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
