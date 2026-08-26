<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Orders Dashboard') - Power Joins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top, #111827, #0b0f19);
            color: #e5e7eb;
            min-height: 100vh;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .title { font-size: 18px; font-weight: 600; }
        .badge-soft {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 18px;
            backdrop-filter: blur(10px);
        }
        .stat-title { font-size: 13px; color: #9ca3af; }
        .stat-value { font-size: 28px; font-weight: bold; }
        .search-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 10px;
            border-radius: 10px;
        }
        .search-box::placeholder { color: rgba(255,255,255,0.4); }
        .btn-glow {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none; color: white;
            border-radius: 10px; padding: 10px 20px;
        }
        .btn-glow:hover { opacity: 0.9; color: white; }
        .table-glass {
            background: rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            overflow: hidden;
        }
        table { color: #e5e7eb; }
        thead { background: rgba(255, 255, 255, 0.06); }
        th { color: #93c5fd; }
        .nav-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 15px;
            color: #e5e7eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .nav-card:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #60a5fa;
            transform: translateY(-2px);
        }
        .nav-card i { font-size: 24px; }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.4) !important; }
        .form-select option { background: #1f2937; color: white; }
        .form-label { color: #9ca3af; }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
            border-radius: 12px;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            border-radius: 12px;
        }
        .pagination .page-link {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.1);
            color: #e5e7eb;
        }
        .pagination .page-link:hover { background: rgba(255,255,255,0.1); }
        .pagination .active .page-link { background: #3b82f6; border-color: #3b82f6; }
        .chart-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="topbar">
    <div class="title">@yield('title', '⚡ Orders Dashboard')</div>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.index') }}" class="badge-soft text-decoration-none">Orders</a>
        <a href="{{ route('users.index') }}" class="badge-soft text-decoration-none">Users</a>
        <a href="{{ route('products.index') }}" class="badge-soft text-decoration-none">Products</a>
        <a href="{{ route('categories.index') }}" class="badge-soft text-decoration-none">Categories</a>
        <a href="{{ route('power-joins.nested') }}" class="badge-soft text-decoration-none">Power Joins</a>
    </div>
</div>

<div class="container-fluid mt-4 px-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
