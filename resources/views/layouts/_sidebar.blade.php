@php($u = auth()->user())
<aside class="sidebar" id="sidebar" aria-label="Main navigation">
    <a class="sb-brand" href="{{ $u->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}">
        <span class="sb-logo" aria-hidden="true">G</span>
        <span class="sb-text">
            <strong>Grand Stay</strong>
            <small>{{ $u->isAdmin() ? 'Admin panel' : 'Guest portal' }}</small>
        </span>
    </a>

    <nav class="sb-nav">
        @if ($u->isAdmin())
            <div class="sb-section sb-text">Overview</div>
            <x-sb-link :href="route('admin.dashboard')" icon="grid-1x2" :active="request()->routeIs('admin.dashboard')">Dashboard</x-sb-link>

            <div class="sb-section sb-text">Manage</div>
            <x-sb-link :href="route('admin.bookings.index')" icon="calendar2-check" :active="request()->routeIs('admin.bookings.*')" :badge="$pendingCount ?: null">Bookings</x-sb-link>
            <x-sb-link :href="route('admin.rooms.index')" icon="door-open" :active="request()->routeIs('admin.rooms.*')">Rooms</x-sb-link>
            <x-sb-link :href="route('admin.users.index')" icon="people" :active="request()->routeIs('admin.users.*')">Guests</x-sb-link>

            <div class="sb-section sb-text">Quick actions</div>
            <x-sb-link :href="route('admin.bookings.create')" icon="plus-circle" :active="request()->routeIs('admin.bookings.create')">New booking</x-sb-link>
        @else
            <div class="sb-section sb-text">Menu</div>
            <x-sb-link :href="route('user.dashboard')" icon="grid-1x2" :active="request()->routeIs('user.dashboard')">Dashboard</x-sb-link>
            <x-sb-link :href="route('home')" icon="building" :active="request()->routeIs('home') || request()->routeIs('user.bookings.create')">Browse rooms</x-sb-link>
            <x-sb-link :href="route('user.bookings.index')" icon="journal-bookmark" :active="request()->routeIs('user.bookings.index') || request()->routeIs('user.bookings.show')">My bookings</x-sb-link>

            <div class="sb-section sb-text">Account</div>
            <x-sb-link :href="route('profile.edit')" icon="person-gear" :active="request()->routeIs('profile.*')">Profile</x-sb-link>
        @endif
    </nav>

    <div class="sb-footer">
        <div class="sb-user">
            <span class="avatar" aria-hidden="true">{{ $u->initials }}</span>
            <span class="sb-user-meta">
                <strong>{{ $u->name }}</strong>
                <small>{{ $u->isAdmin() ? 'Administrator' : 'Guest' }}</small>
            </span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sb-logout" title="Log out"><i class="bi bi-box-arrow-left" aria-hidden="true"></i><span class="sb-text">Log out</span></button>
        </form>
    </div>
</aside>
