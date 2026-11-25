@extends('layouts.app')
@section('title', 'Guests')

@section('content')
<div class="page-head"><div><h1 class="h4 mb-0">Registered guests</h1><p>Everyone with a guest account.</p></div></div>

<form method="GET" class="panel p-3 mb-4 d-flex gap-2">
    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or email" aria-label="Search guests">
    <button class="btn btn-dark">Search</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Clear</a>
</form>

<div class="panel">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Phone</th><th class="text-center">Bookings</th><th>Joined</th></tr></thead>
            <tbody>
            @forelse ($users as $u)
                <tr>
                    <td><a href="{{ route('admin.users.show', $u) }}" class="fw-semibold text-decoration-none">{{ $u->name }}</a></td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone }}</td>
                    <td class="text-center">{{ $u->bookings_count }}</td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No guests found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
