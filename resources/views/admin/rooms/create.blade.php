@extends('layouts.app')
@section('title', 'Add room')

@section('content')
<h1 class="h4 mb-3">Add room</h1>
<form method="POST" action="{{ route('admin.rooms.store') }}" class="panel p-4" novalidate>
    @csrf
    @include('admin.rooms._form')
</form>
@endsection
