@extends('powerjoins.layout')

@section('title', 'Group By Examples')

@section('powerjoin-content')

<div class="row g-4">
    <div class="col-md-6">
        <div class="glass-card">
            <h5 class="mb-3">Orders by Month</h5>
            <code class="text-info d-block mb-3" style="font-size: 12px;">
                Order::selectRaw('DATE_FORMAT, COUNT, SUM')<br>
                &nbsp;&nbsp;->groupBy('month')->get();
            </code>
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Orders</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordersByMonth as $row)
                    <tr>
                        <td>{{ $row->month }}</td>
                        <td>{{ $row->order_count }}</td>
                        <td>₹{{ number_format($row->total_revenue, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="glass-card">
            <h5 class="mb-3">Orders by User & Status</h5>
            <code class="text-info d-block mb-3" style="font-size: 12px;">
                User::joinRelationship('orders')<br>
                &nbsp;&nbsp;->selectRaw('name, status, COUNT, SUM')<br>
                &nbsp;&nbsp;->groupBy('users.id', 'orders.status')->get();
            </code>
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Status</th>
                        <th>Count</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordersByUserAndStatus as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td><span class="badge bg-{{ $row->status == 'completed' ? 'success' : ($row->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($row->status) }}</span></td>
                        <td>{{ $row->order_count }}</td>
                        <td>₹{{ number_format($row->total_amount, 2) }}</td>
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
