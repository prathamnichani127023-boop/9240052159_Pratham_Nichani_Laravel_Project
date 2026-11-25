@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1 class="h4 mb-3">My profile</h1>
        <form method="POST" action="{{ route('profile.update') }}" class="panel p-4" novalidate>
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="name">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" value="{{ $user->email }}" class="form-control" disabled>
            </div>
            <div class="mb-4">
                <label class="form-label" for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="form-control @error('phone') is-invalid @enderror" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <h2 class="h6">Change password <span class="text-muted fw-normal">(leave blank to keep the current one)</span></h2>
            @foreach ([['current_password', 'Current password'], ['password', 'New password'], ['password_confirmation', 'Confirm new password']] as [$f, $l])
                <div class="mb-3">
                    <label class="form-label" for="{{ $f }}">{{ $l }}</label>
                    <input type="password" id="{{ $f }}" name="{{ $f }}" autocomplete="{{ $f === 'current_password' ? 'current-password' : 'new-password' }}"
                           class="form-control @error($f) is-invalid @enderror">
                    @error($f) <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endforeach

            <button class="btn btn-accent">Save changes</button>
        </form>
    </div>
</div>
@endsection
