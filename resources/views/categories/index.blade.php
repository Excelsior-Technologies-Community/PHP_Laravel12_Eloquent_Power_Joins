@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Categories Management</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-glow"><i class="bi bi-plus"></i> Add Category</a>
</div>

<!-- SEARCH -->
<form method="GET" action="{{ route('categories.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box" placeholder="Search categories...">
        </div>
        <div class="col-md-2">
            <button class="btn btn-glow w-100"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-light w-100">Reset</a>
        </div>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @forelse($categories as $category)
    <div class="col-md-3">
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5>{{ $category->name }}</h5>
                    <small class="text-muted">Slug: {{ $category->slug }}</small>
                    <div class="mt-2">
                        <span class="badge bg-info">{{ $category->products_count }} Products</span>
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-4">No categories found</div>
    @endforelse
</div>

<div class="mt-3">{{ $categories->links() }}</div>

@endsection
