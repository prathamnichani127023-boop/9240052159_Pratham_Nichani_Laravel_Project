<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._head')
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>

@auth
    <div class="app-shell">
        @include('layouts._sidebar')
        <div class="sb-overlay" aria-hidden="true"></div>

        <div class="shell-main">
            <header class="topbar">
                <button class="icon-btn" type="button" data-sidebar-toggle aria-label="Toggle sidebar" aria-controls="sidebar">
                    <i class="bi bi-layout-sidebar-inset" aria-hidden="true"></i>
                </button>
                <div class="topbar-title">
                    {{ auth()->user()->isAdmin() ? 'Admin' : 'Guest' }} <span aria-hidden="true">/</span>
                    <strong>@yield('title', 'Hotel')</strong>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Toggle light or dark theme">
                        <i class="bi bi-moon-stars" aria-hidden="true"></i><i class="bi bi-sun" aria-hidden="true"></i>
                    </button>
                    <span class="avatar d-none d-sm-grid" title="{{ auth()->user()->name }}">{{ auth()->user()->initials }}</span>
                </div>
            </header>

            <main id="main" class="content">
                @include('layouts._flash')
                @yield('content')
            </main>
        </div>
    </div>
@else
    <nav class="public-nav" aria-label="Main navigation">
        <div class="inner">
            <a class="sb-brand" href="{{ route('home') }}">
                <span class="sb-logo" aria-hidden="true">G</span>
                <span><strong>Grand Stay</strong><small>Hotel &amp; Suites</small></span>
            </a>
            <div class="links">
                <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Toggle light or dark theme">
                    <i class="bi bi-moon-stars" aria-hidden="true"></i><i class="bi bi-sun" aria-hidden="true"></i>
                </button>
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Log in</a>
                <a href="{{ route('register') }}" class="btn btn-accent btn-sm">Register</a>
            </div>
        </div>
    </nav>
    <main id="main" class="content">
        @include('layouts._flash')
        @yield('content')
    </main>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
