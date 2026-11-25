@extends('layouts.app')
@section('title', $user->name)

@section('content')
<h1 class="h4 mb-1">{{ $user->name }}</h1>
<p class="text-muted">{{ $user->email }} · {{ $user->phone }} · joined {{ $user->created_at->format('d M Y') }}</p>

<div class="panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>#</th><th>Room</th><th>Stay</th><th class="text-end">Total</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($bookings as $b)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->id }}</a></td>
                    <td>{{ $b->room->room_number }} <span class="text-muted small">{{ $b->room->type }}</span></td>
                    <td>{{ $b->check_in->format('d M Y') }} – {{ $b->check_out->format('d M Y') }}</td>
                    <td class="text-end money">₹{{ number_format($b->total_cost, 2) }}</td>
                    <td><span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">This guest has no bookings yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<a href="{{ route('admin.users.index') }}" class="d-inline-block mt-3">Back to guests</a>
@endsection
