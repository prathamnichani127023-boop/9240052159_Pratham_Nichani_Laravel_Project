@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
<div class="page-head">
    <div><h1 class="h4 mb-0">Rooms</h1><p>Types, capacity and nightly rates.</p></div>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i> Add room</a>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr><th>Room</th><th>Type</th><th class="text-center">Capacity</th><th class="text-end">Price / night</th><th class="text-center">Bookings</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($rooms as $r)
                <tr>
                    <td class="fw-semibold">{{ $r->room_number }}</td>
                    <td>{{ $r->type }}</td>
                    <td class="text-center">{{ $r->capacity }}</td>
                    <td class="text-end money">₹{{ number_format($r->price_per_night, 2) }}</td>
                    <td class="text-center">{{ $r->bookings_count }}</td>
                    <td><span class="badge text-bg-{{ $r->is_active ? 'success' : 'secondary' }}">{{ $r->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.rooms.edit', $r) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                        <form action="{{ route('admin.rooms.destroy', $r) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete room {{ $r->room_number }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No rooms yet. <a href="{{ route('admin.rooms.create') }}">Add the first room</a></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $rooms->links() }}</div>
@endsection
