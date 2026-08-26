@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit User: {{ $user->name }}</h4>
    <a href="{{ route('users.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="glass-card">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-glow"><i class="bi bi-check-lg"></i> Update User</button>
            </div>
        </div>
    </div>
</form>

@endsection
