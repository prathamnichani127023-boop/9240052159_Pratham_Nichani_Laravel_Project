@props(['href', 'icon', 'active' => false, 'badge' => null])
<a href="{{ $href }}" class="sb-link {{ $active ? 'active' : '' }}" title="{{ trim(strip_tags((string) $slot)) }}" @if ($active) aria-current="page" @endif>
    <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
    <span class="sb-text">{{ $slot }}</span>
    @if ($badge)<span class="sb-badge sb-text">{{ $badge }}</span>@endif
</a>
