@extends('layouts.auth')
@section('title', 'Sign in')
@section('hero_heading', 'Welcome back to the front desk.')
@section('hero_text', 'Sign in as a guest to manage your stays, or as admin to run the hotel.')

@section('content')
    <h2>Sign in</h2>
    <p class="sub">Use your email and password. You will be taken to your own panel.</p>

    @if ($errors->has('email') && ! old('email'))
        <div class="alert alert-danger py-2" role="alert">{{ $errors->first('email') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <x-field name="email" label="Email (username)" icon="envelope" type="email" autocomplete="username"
                 :value="old('email')" placeholder="you@example.com" :i="1" autofocus />
        <x-field name="password" label="Password" icon="lock" type="password" autocomplete="current-password"
                 placeholder="Your password" :toggle="true" :i="2" />

        @if ($errors->has('email') && old('email'))
            <p class="field-error mb-3"><i class="bi bi-exclamation-circle" aria-hidden="true"></i> {{ $errors->first('email') }}</p>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3 rise" style="--i:3">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Keep me signed in</label>
            </div>
        </div>

        <button class="btn btn-accent btn-auth rise" style="--i:4">Sign in <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
    </form>

    <p class="auth-alt">New guest? <a href="{{ route('register') }}">Create an account</a></p>

    @if (app()->environment('local'))
        <details class="demo">
            <summary>Demo accounts (local only)</summary>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-dark btn-sm" data-fill="guest@hotel.com">Fill guest</button>
                <button type="button" class="btn btn-outline-dark btn-sm" data-fill="admin@hotel.com">Fill admin</button>
            </div>
        </details>
    @endif
@endsection
