@props(['name', 'label', 'icon', 'type' => 'text', 'autocomplete' => 'off', 'value' => null, 'toggle' => false, 'strength' => false, 'i' => 2])
<div class="field-group rise" style="--i: {{ $i }}">
    <label for="{{ $name }}" class="field-label">{{ $label }}</label>
    <div class="field @error($name) invalid @enderror">
        <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $autocomplete }}"
               @if ($value !== null) value="{{ $value }}" @endif
               @error($name) aria-invalid="true" @enderror required {{ $attributes }}>
        @if ($toggle)
            <button type="button" class="field-toggle" data-toggle-password="{{ $name }}" aria-label="Show password"><i class="bi bi-eye"></i></button>
        @endif
    </div>
    @if ($strength)
        <div class="meter" data-meter data-level="0" aria-hidden="true"><span></span></div>
        <p class="meter-text" data-meter-text>Use 8+ characters with letters and numbers.</p>
    @endif
    @error($name)
        <p class="field-error"><i class="bi bi-exclamation-circle" aria-hidden="true"></i> {{ $message }}</p>
    @enderror
</div>
