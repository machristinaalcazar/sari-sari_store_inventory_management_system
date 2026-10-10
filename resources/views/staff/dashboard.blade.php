@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <!-- Dashboard Role Identification Required by IAS1 Lab 2 -->
        <h2>Welcome Staff!</h2>
        <p class="text-muted">Product availability search and quick transaction terminal.</p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="{{ route('staff.dashboard') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search product name or category..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('sales.create') }}" class="btn btn-success fw-bold">+ Record New Sale</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">Product Availability Catalog</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th>Stock Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->stock_quantity <= 0)
                            <span class="badge bg-danger">Out of Stock</span>
                        @elseif($product->stock_quantity <= $product->reorder_threshold)
                            <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock_quantity }})</span>
                        @else
                            <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection