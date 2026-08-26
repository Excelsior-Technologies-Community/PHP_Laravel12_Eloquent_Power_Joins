@extends('powerjoins.layout')

@section('title', 'Left Joins')

@section('powerjoin-content')

<div class="glass-card mb-4">
    <h5 class="mb-2">Query: Products with LEFT JOIN to orderItems (shows products with no orders too)</h5>
    <code class="text-info">
        Product::leftJoinRelationship('orderItems')->leftJoinRelationship('category')->get();
    </code>
</div>

<div class="table-glass">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Total Ordered</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $row)
            <tr>
                <td>{{ $row->product_name }}</td>
                <td><span class="badge bg-info">{{ $row->category_name ?? 'N/A' }}</span></td>
                <td>₹{{ number_format($row->price, 2) }}</td>
                <td>{{ $row->total_ordered }}</td>
                <td>
                    @if($row->total_ordered > 0)
                        <span class="badge bg-success">Ordered</span>
                    @else
                        <span class="badge bg-secondary">No Orders</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
