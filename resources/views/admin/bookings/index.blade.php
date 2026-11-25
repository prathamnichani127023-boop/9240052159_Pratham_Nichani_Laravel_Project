@extends('layouts.app')
@section('title', 'Bookings')

@section('content')
<div class="page-head">
    <div><h1 class="h4 mb-0">Bookings</h1><p>Search, filter and manage every reservation.</p></div>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> New booking</a>
</div>

<div class="panel p-3 mb-4">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small mb-1" for="search">Guest name</label>
            <input type="search" id="search" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Search by guest name">
        </div>
        <div class="col-md-2">
            <label class="form-label small mb-1" for="check_in_from">Check-in from</label>
            <input type="date" id="check_in_from" name="check_in_from" value="{{ request('check_in_from') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label small mb-1" for="check_in_to">Check-in to</label>
            <input type="date" id="check_in_to" name="check_in_to" value="{{ request('check_in_to') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label small mb-1" for="status">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">All statuses</option>
                @foreach ($statuses as $s)
                    <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-dark flex-fill">Apply</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>#</th><th>Guest</th><th>Room</th><th>Stay</th>
                <th class="text-center">Guests</th><th class="text-end">Total</th><th>Status</th><th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->guest_name }}</a>
                        <div class="small text-muted">{{ $b->guest_phone }}</div>
                    </td>
                    <td>{{ $b->room->room_number }} <span class="text-muted small">{{ $b->room->type }}</span></td>
                    <td>
                        {{ $b->check_in->format('d M Y') }} – {{ $b->check_out->format('d M Y') }}
                        <div class="small text-muted">{{ $b->nights }} {{ Str::plural('night', $b->nights) }}</div>
                    </td>
                    <td class="text-center">{{ $b->guests }}</td>
                    <td class="text-end money">₹{{ number_format($b->total_cost, 2) }}</td>
                    <td><span class="badge text-bg-{{ $b->status->badge() }}">{{ $b->status->label() }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.bookings.edit', $b) }}" class="btn btn-sm btn-outline-dark">Edit</a>

                        @if ($b->status !== \App\Enums\BookingStatus::Cancelled)
                            <form action="{{ route('admin.bookings.cancel', $b) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning">Cancel</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.bookings.destroy', $b) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this booking record?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"><div class="empty"><i class="bi bi-search"></i><strong>No bookings match these filters</strong><a href="{{ route('admin.bookings.create') }}">Create a booking</a></div></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $bookings->links() }}</div>
@endsection
