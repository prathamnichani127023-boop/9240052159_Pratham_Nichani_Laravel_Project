<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Hotel') · Grand Stay</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script>
    /* Apply saved theme + sidebar state before first paint (no flash). */
    try {
        var t = localStorage.getItem('theme') || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.dataset.theme = t;
        document.documentElement.setAttribute('data-bs-theme', t);
        if (localStorage.getItem('sb') === '1') document.documentElement.classList.add('sb-collapsed');
    } catch (e) {}
</script>
