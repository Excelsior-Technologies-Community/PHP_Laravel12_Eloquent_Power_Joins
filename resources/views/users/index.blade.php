@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Users Management</h4>
    <a href="{{ route('users.create') }}" class="btn btn-glow"><i class="bi bi-plus"></i> Add User</a>
</div>

<!-- SEARCH -->
<form method="GET" action="{{ route('users.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box" placeholder="Search by name or email...">
        </div>
        <div class="col-md-2">
            <button class="btn btn-glow w-100"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline-light w-100">Reset</a>
        </div>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-glass">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Orders</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-info">{{ $user->orders_count }}</span></td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No users found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $users->links() }}</div>

@endsection
