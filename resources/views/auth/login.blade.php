
@extends('layouts.layout')

@section('content')
    <h2>Login</h2>



    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Session Status -->
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div>
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>
        </div>

        <div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
   
@endsection