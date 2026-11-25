@extends('layouts.app')
@section('title', 'Booking #'.$booking->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Booking #{{ $booking->id }}
        <span class="badge text-bg-{{ $booking->status->badge() }} ms-2 fs-6">{{ $booking->status->label() }}</span>
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-outline-dark btn-sm">Edit</a>
        @if ($booking->status !== \App\Enums\BookingStatus::Cancelled)
            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Cancel this booking?')">
                @csrf @method('PATCH')
                <button class="btn btn-outline-warning btn-sm">Cancel booking</button>
            </form>
        @endif
        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this booking record?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>

<div class="panel p-4">
    <dl class="row mb-0">
        <dt class="col-sm-3">Guest</dt><dd class="col-sm-9">{{ $booking->guest_name }}</dd>
        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $booking->guest_email }}</dd>
        <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $booking->guest_phone }}</dd>
        <dt class="col-sm-3">Room</dt><dd class="col-sm-9">{{ $booking->room->label }}</dd>
        <dt class="col-sm-3">Check-in</dt><dd class="col-sm-9">{{ $booking->check_in->format('D, d M Y') }}</dd>
        <dt class="col-sm-3">Check-out</dt><dd class="col-sm-9">{{ $booking->check_out->format('D, d M Y') }} ({{ $booking->nights }} {{ Str::plural('night', $booking->nights) }})</dd>
        <dt class="col-sm-3">Guests</dt><dd class="col-sm-9">{{ $booking->guests }}</dd>
        <dt class="col-sm-3">Total cost</dt><dd class="col-sm-9 money fw-semibold">₹{{ number_format($booking->total_cost, 2) }}</dd>
        <dt class="col-sm-3">Notes</dt><dd class="col-sm-9">{{ $booking->notes ?: '—' }}</dd>
    </dl>
</div>

<a href="{{ route('admin.bookings.index') }}" class="d-inline-block mt-3">Back to bookings</a>
@endsection
