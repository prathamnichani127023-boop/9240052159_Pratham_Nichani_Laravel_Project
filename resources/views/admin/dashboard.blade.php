@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1 class="h4 mb-0">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ Str::before(auth()->user()->name, ' ') }}</h1>
        <p>{{ now()->format('l, d F Y') }}</p>
    </div>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> New booking</a>
</div>

<div class="row g-3 mb-4">
    @foreach ([
        ['Pending bookings', $pending, 'hourglass-split', 'var(--warn)'],
        ['Total bookings', $totalBookings, 'journal-text', 'var(--primary)'],
        ['Revenue', '₹'.number_format($revenue, 0), 'currency-rupee', 'var(--ok)'],
        ['Active rooms', $rooms, 'door-open', 'var(--info)'],
        ['Registered guests', $guests, 'people', 'var(--accent)'],
    ] as [$label, $value, $icon, $tint])
        <div class="col-6 col-xl rise" style="--i: {{ $loop->index }}">
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

@php
    $segments = [
        'pending' => ['Pending', 'var(--warn)'], 'confirmed' => ['Confirmed', 'var(--primary)'],
        'checked_in' => ['Checked in', 'var(--info)'], 'completed' => ['Completed', 'var(--ok)'],
        'cancelled' => ['Cancelled', 'var(--neutral)'],
    ];
    $sum = max($totalBookings, 1);
@endphp

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="panel p-3 h-100">
            <h2 class="h6 mb-3">Bookings by status</h2>
            <div class="dist" role="img" aria-label="Bookings by status">
                @foreach ($segments as $key => [$name, $color])
                    <span style="--w: {{ round(($statusCounts[$key] ?? 0) / $sum * 100, 1) }}%; --c: {{ $color }}"></span>
                @endforeach
            </div>
            <div class="dist-legend">
                @foreach ($segments as $key => [$name, $color])
                    <span style="--c: {{ $color }}"><i></i>{{ $name }} <strong class="text-body">{{ $statusCounts[$key] ?? 0 }}</strong></span>
                @endforeach
            </div>
        </div>
    </div>

    @foreach ([['Check-ins today', $checkInsToday, 'box-arrow-in-right'], ['Check-outs today', $checkOutsToday, 'box-arrow-right']] as [$title, $list, $icon])
        <div class="col-md-6 col-lg-4">
            <div class="panel p-3 h-100">
                <h2 class="h6 mb-2"><i class="bi bi-{{ $icon }} me-1" aria-hidden="true"></i> {{ $title }}</h2>
                @forelse ($list as $b)
                    <div class="mini-row">
                        <span class="dot"></span>
                        <div class="flex-grow-1">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->guest_name }}</a>
                            <div class="small text-muted">Room {{ $b->room->room_number }} · {{ $b->guests }} {{ Str::plural('guest', $b->guests) }}</div>
                        </div>
                        <span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span>
                    </div>
                @empty
                    <div class="empty py-4"><i class="bi bi-moon-stars"></i><span>Nothing scheduled today.</span></div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

<div class="panel">
    <div class="p-3 pb-2 d-flex justify-content-between align-items-center">
        <h2 class="h6 mb-0">Latest bookings</h2>
        <a href="{{ route('admin.bookings.index') }}" class="small">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>#</th><th>Guest</th><th>Room</th><th>Check-in</th><th class="text-end">Total</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($recent as $b)
                <tr>
                    <td class="text-muted">{{ $b->id }}</td>
                    <td><a href="{{ route('admin.bookings.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->guest_name }}</a></td>
                    <td>{{ $b->room->room_number }}</td>
                    <td>{{ $b->check_in->format('d M Y') }}</td>
                    <td class="text-end money">₹{{ number_format($b->total_cost, 2) }}</td>
                    <td><span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><i class="bi bi-journal-x"></i><span>No bookings yet.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
