@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Products Management</h4>
    <a href="{{ route('products.create') }}" class="btn btn-glow"><i class="bi bi-plus"></i> Add Product</a>
</div>

<!-- SEARCH + FILTER -->
<form method="GET" action="{{ route('products.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box" placeholder="Search products...">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select search-box">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-glow w-100"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-light w-100">Reset</a>
        </div>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-glass">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if($product->category)
                        <span class="badge bg-info">{{ $product->category->name }}</span>
                    @else
                        <span class="text-muted">Uncategorized</span>
                    @endif
                </td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No products found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $products->links() }}</div>

@endsection
