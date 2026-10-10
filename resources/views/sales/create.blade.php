@extends('layouts.app')

@section('title', 'New Transaction')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Point of Sale (POS) Transaction</div>
            <div class="card-body">
                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf
                    <div id="item-rows">
                        <div class="row mb-3 item-row">
                            <div class="col-md-6">
                                <label>Product</label>
                                <select name="items[0][product_id]" class="form-select" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - ₱{{ number_format($product->price, 2) }} (Stock: {{ $product->stock_quantity }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Quantity</label>
                                <input type="number" name="items[0][quantity]" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Complete Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection