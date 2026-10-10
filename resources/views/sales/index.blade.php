@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daily Sales Transaction Log</h3>
    <div class="badge bg-success p-2 fs-6">Today's Revenue: ₱{{ number_format($dailyTotal, 2) }}</div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Processed By</th>
                    <th>Total Amount</th>
                    <th>Items Purchased</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                    <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach($sale->items as $item)
                                <li>{{ $item->product->name ?? 'Deleted Product' }} x {{ $item->quantity }} @ ₱{{ number_format($item->unit_price, 2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $sale->created_at->format('Y-m-d H:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sales->links() }}
    </div>
</div>
@endsection