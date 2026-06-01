<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Orders Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top, #111827, #0b0f19);
            color: #e5e7eb;
        }

        /* TOP BAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .title {
            font-size: 18px;
            font-weight: 600;
        }

        .badge-soft {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* GLASS CARD */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 18px;
            backdrop-filter: blur(10px);
            transition: 0.3s;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59, 130, 246, 0.4);
        }

        .stat-title {
            font-size: 13px;
            color: #9ca3af;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* SEARCH */
        .search-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 10px 12px;
            border-radius: 10px;
        }

        .search-box:focus {
            outline: none;
            border-color: #3b82f6;
        }

        /* BUTTON */
        .btn-glow {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-glow:hover {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* TABLE */
        .table-glass {
            background: rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        table {
            margin: 0;
            color: #e5e7eb;
        }

        thead {
            background: rgba(255, 255, 255, 0.06);
        }

        th {
            font-weight: 500;
            color: #93c5fd;
            border: none !important;
        }

        td {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        tr:hover {
            background: rgba(59, 130, 246, 0.1);
        }

        /* BADGE */
        .badge-custom {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            padding: 6px 10px;
            border-radius: 8px;
        }

        /* DELETE */
        .btn-delete {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            border-radius: 8px;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        /* ALERT */
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
            border-radius: 12px;
        }

        /* PAGINATION ONLY NUMBERS */
        .pagination {
            justify-content: center;
            gap: 6px;
        }

        .pagination .page-item:first-child,
        .pagination .page-item:last-child {
            display: none;
        }

        .pagination .page-link {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            border-radius: 8px;
        }

        .pagination .active .page-link {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .search-box::placeholder {
            color: #9ca3af;
            opacity: 1;
            font-weight: 400;
        }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="title">⚡ Orders Dashboard</div>
        <div class="badge-soft">Laravel 12 • Power Joins</div>
    </div>

    <div class="container mt-4">

        <!-- STATS -->
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="glass-card">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                </div>
            </div>

        </div>

        <!-- SEARCH -->
        <form method="GET" action="/orders" class="mb-4">
            <div class="row g-2">

                <div class="col-md-10">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box"
                        placeholder="Search User / Order / Product">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-glow w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="table-glass">

            <table class="table table-dark table-hover mb-0">

                <thead>
                    <tr>
                        <th>User</th>
                        <th>Order No</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($orders as $order)

                        <tr>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->order_no }}</td>
                            <td>{{ $order->product_name }}</td>

                            <td>
                                <span class="badge-custom">
                                    {{ $order->qty }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-delete btn-sm" onclick="return confirm('Delete this order?')">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $orders->links() }}
        </div>

    </div>

</body>

</html>