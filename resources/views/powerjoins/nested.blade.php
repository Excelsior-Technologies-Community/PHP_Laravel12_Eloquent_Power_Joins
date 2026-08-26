@extends('powerjoins.layout')

@section('title', 'Nested Joins')

@section('powerjoin-content')

<div class="glass-card mb-4">
    <h5 class="mb-2">Query: orders → user → items → product → category</h5>
    <code class="text-info">
        Order::joinRelationship('user')->joinRelationship('items.product.category')->get();
    </code>
</div>

<div class="table-glass">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>Order #</th>
                <th>User</th>
                <th>Product</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $row)
            <tr>
                <td>{{ $row->order_number }}</td>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->product_name }}</td>
                <td><span class="badge bg-info">{{ $row->category_name ?? 'N/A' }}</span></td>
                <td>{{ $row->quantity }}</td>
                <td>₹{{ number_format($row->price, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
