@extends('layouts.layout')

@section('content')
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-success">Verify Your Email</h2>
        <p class="text-muted">
            Thanks for signing up! Please check your inbox for a verification email.
            <br>
            Didn't receive it? We can send another.
        </p>
    </div>

    <div class="mx-auto" style="max-width: 500px;">
        {{-- Status Message --}}
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-4 gap-2 flex-wrap">

            {{-- Resend Verification Email --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary text-success">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>

    {{-- Optional: Button Hover Effects --}}
    
@endsection
