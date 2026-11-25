@extends('layouts.app')
@section('title', 'Edit room '.$room->room_number)

@section('content')
<h1 class="h4 mb-3">Edit room {{ $room->room_number }}</h1>
<form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="panel p-4" novalidate>
    @csrf @method('PUT')
    @include('admin.rooms._form')
</form>
@endsection
