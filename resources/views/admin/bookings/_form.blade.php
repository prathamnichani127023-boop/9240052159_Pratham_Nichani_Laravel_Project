@php($isEdit = $booking->exists)

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Fix the following before saving:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="guest_name">Guest name</label>
        <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name', $booking->guest_name) }}"
               class="form-control @error('guest_name') is-invalid @enderror" required>
        @error('guest_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="guest_email">Email</label>
        <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email', $booking->guest_email) }}"
               class="form-control @error('guest_email') is-invalid @enderror" required>
        @error('guest_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="guest_phone">Phone</label>
        <input type="tel" id="guest_phone" name="guest_phone" value="{{ old('guest_phone', $booking->guest_phone) }}"
               class="form-control @error('guest_phone') is-invalid @enderror" required>
        @error('guest_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="room_id">Room</label>
        <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
            <option value="">Select a room</option>
            @foreach ($rooms as $room)
                <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" data-capacity="{{ $room->capacity }}"
                    @selected(old('room_id', $booking->room_id) == $room->id)>
                    {{ $room->label }} — ₹{{ number_format($room->price_per_night, 0) }}/night
                </option>
            @endforeach
        </select>
        @error('room_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="check_in">Check-in</label>
        <input type="date" id="check_in" name="check_in"
               value="{{ old('check_in', optional($booking->check_in)->format('Y-m-d')) }}"
               @unless($isEdit) min="{{ now()->toDateString() }}" @endunless
               class="form-control @error('check_in') is-invalid @enderror" required>
        @error('check_in') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="check_out">Check-out</label>
        <input type="date" id="check_out" name="check_out"
               value="{{ old('check_out', optional($booking->check_out)->format('Y-m-d')) }}"
               class="form-control @error('check_out') is-invalid @enderror" required>
        @error('check_out') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="guests">Number of guests</label>
        <input type="number" min="1" id="guests" name="guests" value="{{ old('guests', $booking->guests) }}"
               class="form-control @error('guests') is-invalid @enderror" required>
        @error('guests') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="status">Status</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach ($statuses as $s)
                <option value="{{ $s->value }}" @selected(old('status', $booking->status?->value) === $s->value)>{{ $s->label() }}</option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Estimated total</label>
        <div class="form-control bg-light money" id="estimate" aria-live="polite">
            {{ $isEdit ? '₹'.number_format($booking->total_cost, 2) : 'Choose a room and dates' }}
        </div>
        <div class="form-text">The final total is calculated when you save.</div>
    </div>

    <div class="col-12">
        <label class="form-label" for="notes">Notes <span class="text-muted">(optional)</span></label>
        <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $booking->notes) }}</textarea>
        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-accent">{{ $isEdit ? 'Save changes' : 'Create booking' }}</button>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Back to bookings</a>
</div>

@push('scripts')
<script>
    const room = document.getElementById('room_id');
    const inEl = document.getElementById('check_in');
    const outEl = document.getElementById('check_out');
    const guests = document.getElementById('guests');
    const est = document.getElementById('estimate');

    function refresh() {
        const opt = room.selectedOptions[0];
        if (opt && opt.dataset.capacity) guests.max = opt.dataset.capacity;

        if (inEl.value) {
            const next = new Date(inEl.value); next.setDate(next.getDate() + 1);
            outEl.min = next.toISOString().slice(0, 10);
        }
        if (!opt || !opt.dataset.price || !inEl.value || !outEl.value) return;

        const nights = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);
        est.textContent = nights > 0
            ? `₹${(nights * opt.dataset.price).toLocaleString('en-IN', {minimumFractionDigits: 2})} for ${nights} night${nights > 1 ? 's' : ''}`
            : 'Check-out must be after check-in';
    }
    [room, inEl, outEl].forEach(el => el.addEventListener('change', refresh));
    refresh();
</script>
@endpush
