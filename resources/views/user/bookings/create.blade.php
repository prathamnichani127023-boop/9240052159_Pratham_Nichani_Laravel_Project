@extends('layouts.app')
@section('title', 'Book room '.$room->room_number)

@section('content')
<h1 class="h4 mb-1">Book {{ $room->type }} · Room {{ $room->room_number }}</h1>
<p class="text-muted">₹{{ number_format($room->price_per_night, 0) }} per night · sleeps up to {{ $room->capacity }}</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Fix the following before booking:</strong>
        <ul class="mb-0 mt-1">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('user.bookings.store', $room) }}" class="panel p-4" novalidate>
    @csrf
    <p class="small text-muted">Booking as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}, {{ auth()->user()->phone }}).
        <a href="{{ route('profile.edit') }}">Update details</a></p>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label" for="check_in">Check-in</label>
            <input type="date" id="check_in" name="check_in" min="{{ now()->toDateString() }}"
                   value="{{ old('check_in', request('check_in')) }}" class="form-control @error('check_in') is-invalid @enderror" required>
            @error('check_in') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label" for="check_out">Check-out</label>
            <input type="date" id="check_out" name="check_out"
                   value="{{ old('check_out', request('check_out')) }}" class="form-control @error('check_out') is-invalid @enderror" required>
            @error('check_out') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label" for="guests">Number of guests</label>
            <input type="number" min="1" max="{{ $room->capacity }}" id="guests" name="guests"
                   value="{{ old('guests', request('guests', 1)) }}" class="form-control @error('guests') is-invalid @enderror" required>
            @error('guests') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label" for="notes">Special requests <span class="text-muted">(optional)</span></label>
            <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
        </div>
        <div class="col-12">
            <div class="form-control bg-light money" id="estimate" aria-live="polite">Choose your dates to see the total</div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button class="btn btn-accent">Request booking</button>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to rooms</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const price = {{ (float) $room->price_per_night }};
    const inEl = document.getElementById('check_in');
    const outEl = document.getElementById('check_out');
    const est = document.getElementById('estimate');

    function refresh() {
        if (inEl.value) {
            const next = new Date(inEl.value); next.setDate(next.getDate() + 1);
            outEl.min = next.toISOString().slice(0, 10);
        }
        if (!inEl.value || !outEl.value) return;
        const nights = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);
        est.textContent = nights > 0
            ? `₹${(nights * price).toLocaleString('en-IN', {minimumFractionDigits: 2})} for ${nights} night${nights > 1 ? 's' : ''}`
            : 'Check-out must be after check-in';
    }
    [inEl, outEl].forEach(el => el.addEventListener('change', refresh));
    refresh();
</script>
@endpush
