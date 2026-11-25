@extends('layouts.auth')
@section('title', 'Create account')
@section('hero_heading', 'Your next stay starts here.')
@section('hero_text', 'Create a free guest account to check availability, book instantly and track every reservation.')

@section('content')
    <h2>Create your account</h2>
    <p class="sub">It takes less than a minute.</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf
        <x-field name="name" label="Full name" icon="person" autocomplete="name" :value="old('name')" placeholder="Your full name" :i="1" autofocus />
        <x-field name="email" label="Email" icon="envelope" type="email" autocomplete="email" :value="old('email')" placeholder="you@example.com" :i="2" />
        <x-field name="phone" label="Phone" icon="telephone" type="tel" autocomplete="tel" :value="old('phone')" placeholder="+91 98765 43210" :i="3" />
        <x-field name="password" label="Password" icon="lock" type="password" autocomplete="new-password" placeholder="At least 8 characters" :toggle="true" :strength="true" :i="4" />
        <x-field name="password_confirmation" label="Confirm password" icon="shield-lock" type="password" autocomplete="new-password" placeholder="Repeat your password" :toggle="true" :i="5" />

        <button class="btn btn-accent btn-auth rise" style="--i:6">Create account <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
    </form>

    <p class="auth-alt">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
