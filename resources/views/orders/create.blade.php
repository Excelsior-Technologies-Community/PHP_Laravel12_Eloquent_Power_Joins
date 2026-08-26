@extends('layouts.app')

@section('title', 'Create Order')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Create New Order</h4>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('orders.store') }}" method="POST" id="orderForm">
    @csrf

    <div class="glass-card mb-4">
        <h5 class="mb-3">Order Details</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Customer</label>
                <select name="user_id" class="form-select" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="glass-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Products</h5>
            <button type="button" class="btn btn-sm btn-glow" onclick="addProductRow()">
                <i class="bi bi-plus"></i> Add Product
            </button>
        </div>

        <div id="productRows">
            <div class="row g-2 mb-2 product-row">
                <div class="col-md-6">
                    <select name="products[0][id]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ₹{{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[0][quantity]" class="form-control qty-input" placeholder="Quantity" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control line-total" placeholder="₹0" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <h5>Grand Total: ₹<span id="grandTotal">0.00</span></h5>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-glow btn-lg"><i class="bi bi-check-lg"></i> Create Order</button>
    </div>
</form>

@endsection

@push('scripts')
<script>
let rowIndex = 1;

function addProductRow() {
    const container = document.getElementById('productRows');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 product-row';
    row.innerHTML = `
        <div class="col-md-6">
            <select name="products[${rowIndex}][id]" class="form-select product-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ₹{{ $product->price }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="products[${rowIndex}][quantity]" class="form-control qty-input" placeholder="Quantity" min="1" value="1" required>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control line-total" placeholder="₹0" readonly>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
        </div>
    `;
    container.appendChild(row);
    rowIndex++;
    attachListeners();
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.product-row');
    if (rows.length > 1) {
        btn.closest('.product-row').remove();
        calculateTotal();
    }
}

function attachListeners() {
    document.querySelectorAll('.product-select, .qty-input').forEach(el => {
        el.onchange = calculateTotal;
        el.oninput = calculateTotal;
    });
}

function calculateTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const qty = row.querySelector('.qty-input');
        const lineTotal = row.querySelector('.line-total');
        const option = select.options[select.selectedIndex];
        const price = parseFloat(option?.dataset?.price || 0);
        const quantity = parseInt(qty.value) || 0;
        const total = price * quantity;
        lineTotal.value = '₹' + total.toFixed(2);
        grandTotal += total;
    });
    document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
}

attachListeners();
</script>
@endpush
