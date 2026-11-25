@extends('layouts.app')
@section('title', 'Edit booking #'.$booking->id)

@section('content')
<h1 class="h4 mb-3">Edit booking #{{ $booking->id }}</h1>
<form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="panel p-4" novalidate>
    @csrf @method('PUT')
    @include('admin.bookings._form')
</form>
@endsection
