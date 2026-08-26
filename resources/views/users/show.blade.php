@extends('layouts.app')

@section('title', 'User Profile')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>User Profile: {{ $user->name }}</h4>
    <a href="{{ route('users.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="glass-card text-center">
            <i class="bi bi-person-circle" style="font-size: 64px;"></i>
            <h4 class="mt-3">{{ $user->name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value text-primary">{{ $user->orders->count() }}</div>
                </div>
                <div class="col-6">
                    <div class="stat-title">Total Spent</div>
                    <div class="stat-value text-success">₹{{ number_format($user->orders->sum('total_amount'), 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="glass-card">
            <h5 class="mb-3">Order History</h5>
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Products</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->items->count() }} items</td>
                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
