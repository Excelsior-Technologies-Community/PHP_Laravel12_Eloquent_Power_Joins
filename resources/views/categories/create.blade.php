@extends('layouts.app')

@section('title', 'Create Category')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Create New Category</h4>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</a>
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

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="glass-card">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-glow"><i class="bi bi-check-lg"></i> Create Category</button>
            </div>
        </div>
    </div>
</form>

@endsection
