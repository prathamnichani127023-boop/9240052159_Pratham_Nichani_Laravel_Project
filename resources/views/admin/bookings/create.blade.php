@extends('layouts.app')
@section('title', 'New booking')

@section('content')
<h1 class="h4 mb-3">New booking</h1>
<form method="POST" action="{{ route('admin.bookings.store') }}" class="panel p-4" novalidate>
    @csrf
    @include('admin.bookings._form')
</form>
@endsection
