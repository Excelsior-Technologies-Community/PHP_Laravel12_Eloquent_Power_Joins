@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Product: {{ $product->name }}</h4>
    <a href="{{ route('products.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</a>
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

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="glass-card">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price (₹)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" min="0" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-glow"><i class="bi bi-check-lg"></i> Update Product</button>
            </div>
        </div>
    </div>
</form>

@endsection
