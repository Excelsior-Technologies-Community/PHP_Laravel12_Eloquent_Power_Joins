@extends('layouts.app')

@section('title', 'Power Joins Demo')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Power Joins Examples</h4>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Dashboard</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <a href="{{ route('power-joins.nested') }}" class="nav-card">
            <i class="bi bi-layers text-primary"></i>
            <span>Nested Joins</span>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('power-joins.left-join') }}" class="nav-card">
            <i class="bi bi-arrow-left-circle text-success"></i>
            <span>Left Joins</span>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('power-joins.aggregate') }}" class="nav-card">
            <i class="bi bi-bar-chart text-warning"></i>
            <span>Aggregate Queries</span>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('power-joins.group-by') }}" class="nav-card">
            <i class="bi bi-collection text-info"></i>
            <span>Group By</span>
        </a>
    </div>
</div>

@yield('powerjoin-content')

@endsection
