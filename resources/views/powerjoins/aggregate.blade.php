@extends('powerjoins.layout')

@section('title', 'Aggregate Queries')

@section('powerjoin-content')

<div class="row g-4">
    <div class="col-md-6">
        <div class="glass-card">
            <h5 class="mb-3">User Spending Stats</h5>
            <code class="text-info d-block mb-3" style="font-size: 12px;">
                User::joinRelationship('orders')<br>
                &nbsp;&nbsp;->selectRaw('COUNT, SUM, AVG')<br>
                &nbsp;&nbsp;->groupBy('users.id')->get();
            </code>
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Avg Order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userSpending as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->order_count }}</td>
                        <td>₹{{ number_format($row->total_spent, 2) }}</td>
                        <td>₹{{ number_format($row->avg_order_value, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="glass-card">
            <h5 class="mb-3">Product Sales Stats</h5>
            <code class="text-info d-block mb-3" style="font-size: 12px;">
                Product::joinRelationship('orderItems')<br>
                &nbsp;&nbsp;->selectRaw('SUM, AVG, COUNT')<br>
                &nbsp;&nbsp;->groupBy('products.id')->get();
            </code>
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty Sold</th>
                        <th>Revenue</th>
                        <th>Times Ordered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productStats as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->total_quantity }}</td>
                        <td>₹{{ number_format($row->total_revenue, 2) }}</td>
                        <td>{{ $row->times_ordered }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
