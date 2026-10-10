@extends('layouts.app')

@section('title', 'Stock In')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">Record Stock In / Restock</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.stock_in.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Select Product</label>
                        <select name="product_id" class="form-select" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Current Stock: {{ $product->stock_quantity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Delivered Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label>Supplier Name (Optional)</label>
                        <input type="text" name="supplier" class="form-control" placeholder="e.g. Local Wholesale">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection