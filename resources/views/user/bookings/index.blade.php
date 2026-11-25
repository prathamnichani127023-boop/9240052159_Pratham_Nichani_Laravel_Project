@extends('layouts.app')
@section('title', 'My bookings')

@section('content')
<div class="page-head">
    <div><h1 class="h4 mb-0">My bookings</h1><p>Track and manage your reservations.</p></div>
    <a href="{{ route('home') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> Book a room</a>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>#</th><th>Room</th><th>Stay</th><th class="text-center">Guests</th><th class="text-end">Total</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($bookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->room->room_number }} <span class="text-muted small">{{ $b->room->type }}</span></td>
                    <td>{{ $b->check_in->format('d M Y') }} – {{ $b->check_out->format('d M Y') }}
                        <div class="small text-muted">{{ $b->nights }} {{ Str::plural('night', $b->nights) }}</div></td>
                    <td class="text-center">{{ $b->guests }}</td>
                    <td class="text-end money">₹{{ number_format($b->total_cost, 2) }}</td>
                    <td><span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('user.bookings.show', $b) }}" class="btn btn-sm btn-outline-dark">View</a>
                        @if ($b->canBeCancelledByUser())
                            <form action="{{ route('user.bookings.cancel', $b) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning">Cancel</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">You have no bookings yet. <a href="{{ route('home') }}">Find a room</a></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $bookings->links() }}</div>
@endsection
