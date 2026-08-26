@extends('layouts.app')

@section('title', '⚡ Orders Dashboard')

@section('content')

<!-- NAVIGATION CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <a href="{{ route('orders.index') }}" class="nav-card">
            <i class="bi bi-cart-check text-primary"></i>
            <span>Orders</span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('users.index') }}" class="nav-card">
            <i class="bi bi-people text-success"></i>
            <span>Users</span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('products.index') }}" class="nav-card">
            <i class="bi bi-box-seam text-warning"></i>
            <span>Products</span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('categories.index') }}" class="nav-card">
            <i class="bi bi-tags text-info"></i>
            <span>Categories</span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('power-joins.nested') }}" class="nav-card">
            <i class="bi bi-diagram-3 text-danger"></i>
            <span>Power Joins</span>
        </a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('orders.create') }}" class="nav-card">
            <i class="bi bi-plus-circle text-light"></i>
            <span>New Order</span>
        </a>
    </div>
</div>

<!-- REVENUE STATS -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="glass-card">
            <div class="stat-title">Total Users</div>
            <div class="stat-value text-primary">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card">
            <div class="stat-title">Total Orders</div>
            <div class="stat-value text-success">{{ $totalOrders }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card">
            <div class="stat-title">Total Products</div>
            <div class="stat-value text-warning">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card">
            <div class="stat-title">Total Revenue</div>
            <div class="stat-value text-info">₹{{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="glass-card">
            <div class="stat-title">Today's Revenue</div>
            <div class="stat-value text-success">₹{{ number_format($todayRevenue, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card">
            <div class="stat-title">Monthly Revenue</div>
            <div class="stat-value text-warning">₹{{ number_format($monthlyRevenue, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card">
            <div class="stat-title">Avg Order Value</div>
            <div class="stat-value text-danger">
                ₹{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}
            </div>
        </div>
    </div>
</div>

<!-- CHART + RECENT ORDERS -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="mb-3">Orders by Status</h5>
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="mb-3">Recent Orders</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $ro)
                        <tr>
                            <td>{{ $ro->order_number }}</td>
                            <td>{{ $ro->user->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $ro->status_badge }}">{{ ucfirst($ro->status) }}</span>
                            </td>
                            <td>{{ $ro->created_at->format('d M') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TOP PRODUCTS -->
<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="chart-container">
            <h5 class="mb-3">Top Selling Products</h5>
            <div class="row">
                @forelse($topProducts as $tp)
                <div class="col-md-2 col-6 text-center mb-3">
                    <div class="glass-card">
                        <i class="bi bi-trophy-fill text-warning" style="font-size: 24px;"></i>
                        <div class="mt-2 fw-bold">{{ $tp->name }}</div>
                        <small class="text-muted">{{ $tp->total_sold }} sold</small>
                    </div>
                </div>
                @empty
                <p class="text-muted">No product sales yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- SEARCH + FILTERS -->
<form method="GET" action="{{ route('orders.index') }}" class="mb-4">
    <div class="glass-card">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box" placeholder="Search User / Order / Product">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select search-box">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="user_id" class="form-select search-box">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id')==$user->id?'selected':'' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="product_id" class="form-select search-box">
                    <option value="">All Products</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id')==$product->id?'selected':'' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-glow w-100"><i class="bi bi-search"></i></button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-light w-100">Reset</a>
            </div>
        </div>
        <div class="row g-2 mt-2">
            <div class="col-md-2">
                <label class="form-label small text-muted">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control search-box">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control search-box">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Min Price (₹)</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}" class="form-control search-box" placeholder="0">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Max Price (₹)</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}" class="form-control search-box" placeholder="99999">
            </div>
        </div>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- ORDERS TABLE -->
<div class="table-glass">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>User</th>
                <th>Order No</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->user_name }}</td>
                <td>{{ $order->order_no }}</td>
                <td>{{ $order->product_name }}</td>
                <td><span class="badge bg-secondary">{{ $order->qty }}</span></td>
                <td><span class="badge bg-success">₹{{ number_format($order->total_amount, 2) }}</span></td>
                <td>
                    <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this order?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No orders found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div class="mt-3">
    {{ $orders->links() }}
</div>

@endsection

@push('scripts')
<script>
const ctx = document.getElementById('statusChart').getContext('2d');
const statusData = @json($ordersByStatus);
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: ['#eab308', '#22c55e', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#e5e7eb' } }
        }
    }
});
</script>
@endpush
