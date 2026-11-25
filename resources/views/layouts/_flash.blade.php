@foreach (['success' => ['success', 'check-circle'], 'error' => ['danger', 'exclamation-triangle']] as $key => [$type, $icon])
    @if (session($key))
        <div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
            <div>{{ session($key) }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach
