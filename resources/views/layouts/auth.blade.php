<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._head')
</head>
<body>
<a href="#main" class="skip-link">Skip to form</a>
<div class="auth">
    <section class="auth-hero" aria-hidden="false">
        <span class="orb a"></span><span class="orb b"></span>

        <a class="sb-brand" href="{{ route('home') }}">
            <span class="sb-logo" aria-hidden="true">G</span>
            <span><strong>Grand Stay</strong><small>Hotel &amp; Suites</small></span>
        </a>

        <div>
            <h1 class="rise" style="--i:1">@yield('hero_heading', 'Every booking, perfectly in place.')</h1>
            <p class="lead-text rise" style="--i:2">@yield('hero_text', 'A single portal for reservations, rooms and guests. Fast to use, hard to double-book.')</p>
            <ul class="feature-list">
                <li class="rise" style="--i:3"><span class="ico"><i class="bi bi-calendar2-check"></i></span> Live room availability for your dates</li>
                <li class="rise" style="--i:4"><span class="ico"><i class="bi bi-shield-check"></i></span> No overlapping bookings, ever</li>
                <li class="rise" style="--i:5"><span class="ico"><i class="bi bi-receipt"></i></span> Totals calculated automatically</li>
            </ul>
        </div>

        <div class="hero-stats rise" style="--i:6">
            <div><strong>24/7</strong><span>Online booking</span></div>
            <div><strong>5</strong><span>Room categories</span></div>
            <div><strong>0</strong><span>Double-bookings</span></div>
        </div>
    </section>

    <section class="auth-panel">
        <div class="auth-top">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Rooms</a>
            <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Toggle light or dark theme">
                <i class="bi bi-moon-stars" aria-hidden="true"></i><i class="bi bi-sun" aria-hidden="true"></i>
            </button>
        </div>

        <main id="main" class="auth-card rise">
            <a class="auth-mobile-brand" href="{{ route('home') }}">
                <span class="sb-logo" aria-hidden="true">G</span><strong>Grand Stay</strong>
            </a>
            @yield('content')
        </main>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
