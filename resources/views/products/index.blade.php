@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Product Catalog</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Product</a>
</div>

<!-- Search Form Section -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search by product name or category..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Reorder Level</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->stock_quantity > $product->reorder_threshold ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td>{{ $product->reorder_threshold }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found in inventory.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection