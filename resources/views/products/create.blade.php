@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Product</h4>
            </div>
            <div class="card-body">
                <!-- Validation Errors Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" placeholder="e.g. Snacks, Beverages" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₱)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Initial Stock Quantity</label>
                        <input type="number" min="0" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="reorder_threshold" class="form-label">Low Stock Reorder Threshold</label>
                        <input type="number" min="0" class="form-control" id="reorder_threshold" name="reorder_threshold" value="{{ old('reorder_threshold', 5) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection