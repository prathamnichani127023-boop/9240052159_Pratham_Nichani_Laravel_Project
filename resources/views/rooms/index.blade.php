@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
@guest
    <section class="hero rise">
        <h1>Find your perfect stay.</h1>
        <p>Pick your dates, see which rooms are free, and book in a minute. Create a free account to confirm your reservation.</p>
    </section>
@else
    <div class="page-head">
        <div>
            <h1 class="h4 mb-0">Browse rooms</h1>
            <p>Check availability for your dates and book instantly.</p>
        </div>
    </div>
@endguest

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
    </div>
@endif

<form method="GET" action="{{ route('home') }}" class="panel p-3 mb-4 row g-3 align-items-end mx-0 {{ auth()->guest() ? 'search-bar' : '' }}">
    <div class="col-md-3">
        <label class="form-label" for="check_in">Check-in</label>
        <input type="date" id="check_in" name="check_in" min="{{ now()->toDateString() }}" value="{{ request('check_in') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label" for="check_out">Check-out</label>
        <input type="date" id="check_out" name="check_out" value="{{ request('check_out') }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label" for="guests">Guests</label>
        <input type="number" min="1" max="10" id="guests" name="guests" value="{{ request('guests') }}" class="form-control" placeholder="Any">
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button class="btn btn-accent flex-fill"><i class="bi bi-search me-1"></i> Check availability</button>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

@if ($nights)
    <p class="text-muted mb-3">
        <strong class="text-body">{{ $rooms->count() }}</strong> {{ Str::plural('room', $rooms->count()) }} available for {{ $nights }} {{ Str::plural('night', $nights) }}.
    </p>
@endif

@php($icons = ['single' => 'person', 'double' => 'people', 'family' => 'house-heart', 'deluxe' => 'stars', 'suite' => 'gem'])

<div class="row g-4">
    @forelse ($rooms as $room)
        @php($slug = Str::slug($room->type))
        <div class="col-md-6 col-xl-4 rise" style="--i: {{ $loop->index % 6 }}">
            <article class="panel room-card">
                <div class="room-visual" data-type="{{ $slug }}">
                    <span class="chip left">Room {{ $room->room_number }}</span>
                    <span class="chip right"><i class="bi bi-people"></i> {{ $room->capacity }}</span>
                    <i class="bi bi-{{ $icons[$slug] ?? 'door-closed' }}" aria-hidden="true"></i>
                </div>
                <div class="p-3 d-flex flex-column flex-grow-1">
                    <h2 class="h5 mb-1">{{ $room->type }} room</h2>
                    <p class="text-muted small mb-3">Sleeps up to {{ $room->capacity }} {{ Str::plural('guest', $room->capacity) }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-end gap-2">
                        <div>
                            <div class="money"><span class="fs-5 fw-bold">₹{{ number_format($room->price_per_night, 0) }}</span> <span class="text-muted small">/ night</span></div>
                            @if ($nights)
                                <div class="small text-muted money">₹{{ number_format($room->price_per_night * $nights, 2) }} total</div>
                            @endif
                        </div>
                        <a class="btn btn-accent btn-sm"
                           href="{{ route('user.bookings.create', ['room' => $room] + request()->only('check_in', 'check_out', 'guests')) }}">Book now</a>
                    </div>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12">
            <div class="panel empty">
                <i class="bi bi-calendar-x" aria-hidden="true"></i>
                <strong>No rooms match</strong>
                <span>Try different dates or fewer guests.</span>
            </div>
        </div>
    @endforelse
</div>
@endsection
