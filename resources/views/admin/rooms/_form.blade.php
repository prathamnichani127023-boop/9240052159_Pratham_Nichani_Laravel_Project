@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Fix the following before saving:</strong>
        <ul class="mb-0 mt-1">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label" for="room_number">Room number</label>
        <input type="text" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}"
               class="form-control @error('room_number') is-invalid @enderror" required>
        @error('room_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="type">Type</label>
        <input type="text" id="type" name="type" list="types" value="{{ old('type', $room->type) }}"
               class="form-control @error('type') is-invalid @enderror" required>
        <datalist id="types"><option>Single</option><option>Double</option><option>Family</option><option>Deluxe</option><option>Suite</option></datalist>
        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="capacity">Capacity (guests)</label>
        <input type="number" min="1" max="10" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}"
               class="form-control @error('capacity') is-invalid @enderror" required>
        @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="price_per_night">Price per night (₹)</label>
        <input type="number" min="1" step="0.01" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}"
               class="form-control @error('price_per_night') is-invalid @enderror" required>
        @error('price_per_night') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   @checked(old('is_active', $room->is_active))>
            <label class="form-check-label" for="is_active">Active (available for booking)</label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-accent">{{ $room->exists ? 'Save changes' : 'Add room' }}</button>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Back to rooms</a>
</div>
