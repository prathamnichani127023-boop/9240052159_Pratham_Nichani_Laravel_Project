@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1 class="h4 mb-0">Welcome, {{ Str::before(auth()->user()->name, ' ') }}</h1>
        <p>Here is a summary of your stays.</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-accent"><i class="bi bi-search me-1"></i> Find a room</a>
</div>

<div class="row g-3 mb-4">
    @foreach ([
        ['Upcoming stays', $upcoming, 'calendar2-heart', 'var(--primary)'],
        ['Total bookings', $total, 'journal-text', 'var(--accent)'],
        ['Awaiting confirmation', $pending, 'hourglass-split', 'var(--warn)'],
        ['Total spent', '₹'.number_format($spent, 0), 'wallet2', 'var(--ok)'],
    ] as [$label, $value, $icon, $tint])
        <div class="col-6 col-xl-3 rise" style="--i: {{ $loop->index }}">
            <div class="panel stat-card h-100" style="--tint: {{ $tint }}">
                <span class="stat-icon"><i class="bi bi-{{ $icon }}" aria-hidden="true"></i></span>
                <div>
                    <div class="stat-value money">{{ $value }}</div>
                    <div class="stat-label">{{ $label }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="panel p-3 h-100">
            <h2 class="h6 mb-3">Your next stay</h2>
            @if ($next)
                <div class="room-visual rounded-4 mb-3" data-type="{{ Str::slug($next->room->type) }}" style="height:110px">
                    <span class="chip left">Room {{ $next->room->room_number }}</span>
                    <span class="chip right">{{ $next->check_in->isToday() || $next->check_in->isPast() ? 'Now' : $next->check_in->diffForHumans() }}</span>
                    <i class="bi bi-calendar2-heart" aria-hidden="true" style="font-size:2.4rem"></i>
                </div>
                <div class="fw-semibold">{{ $next->room->type }} room</div>
                <div class="text-muted small mb-2">{{ $next->check_in->format('D, d M') }} → {{ $next->check_out->format('D, d M Y') }} · {{ $next->nights }} {{ Str::plural('night', $next->nights) }}</div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge text-bg-{{ $next->status->badge() }}">{{ $next->status->label() }}</span>
                    <a href="{{ route('user.bookings.show', $next) }}" class="btn btn-outline-dark btn-sm">View details</a>
                </div>
            @else
                <div class="empty">
                    <i class="bi bi-suitcase-lg" aria-hidden="true"></i>
                    <strong>No upcoming stays</strong>
                    <a href="{{ route('home') }}" class="btn btn-accent btn-sm mt-2">Book a room</a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="panel h-100">
            <div class="p-3 pb-2 d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0">Recent bookings</h2>
                <a href="{{ route('user.bookings.index') }}" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light"><tr><th>#</th><th>Room</th><th>Check-in</th><th class="text-end">Total</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse ($recent as $b)
                        <tr>
                            <td><a href="{{ route('user.bookings.show', $b) }}">{{ $b->id }}</a></td>
                            <td>{{ $b->room->room_number }} <span class="text-muted small">{{ $b->room->type }}</span></td>
                            <td>{{ $b->check_in->format('d M Y') }}</td>
                            <td class="text-end money">₹{{ number_format($b->total_cost, 2) }}</td>
                            <td><span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty"><i class="bi bi-journal-x"></i><span>No bookings yet.</span></div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
