@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2>Welcome Admin!</h2>
        <p class="text-muted">Sari-Sari Store Management & External Service Monitoring</p>
    </div>
</div>

<div class="row mb-4">
    <!-- Enhanced Weather Card with Search & Cloud Icon -->
    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #00c4cc;">
                <span class="fw-bold fs-6">External Weather Dashboard</span>
                <span class="badge bg-light text-dark">Live API</span>
            </div>
            
            <div class="card-body p-4" style="background: linear-gradient(135deg, #ffffff 0%, #f4fbfd 100%);">
                <!-- Search City Form -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="city" class="form-control form-control-sm" placeholder="Search city/location..." value="{{ request('city', $searchCity ?? '') }}" required>
                        <button class="btn btn-sm text-white fw-bold" type="submit" style="background-color: #00c4cc;">Search</button>
                    </div>
                </form>

                @if(isset($weatherData) && $weatherData)
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0 fw-bold text-dark">{{ $weatherData['city'] }} <small class="fs-6 text-muted">{{ $weatherData['country'] }}</small></h4>
                            <div class="display-5 fw-bold my-1 text-dark">
                                {{ $weatherData['temp'] }}°C
                            </div>
                            <p class="text-capitalize text-secondary mb-0 fw-semibold">{{ $weatherData['condition'] }}</p>
                        </div>
                        
                        <!-- Weather Icon Graphic -->
                        <div class="text-center">
                            <img src="https://openweathermap.org/img/wn/{{ $weatherData['icon'] }}@4x.png" alt="Weather Icon" style="width: 110px; height: 110px; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.15));">
                        </div>
                    </div>

                    <hr class="my-3" style="opacity: 0.15;">

                    <div class="row text-center text-muted small fw-semibold">
                        <div class="col-4 border-end">
                            <span>Feels Like</span>
                            <div class="text-dark fw-bold fs-6">{{ $weatherData['feels_like'] }}°C</div>
                        </div>
                        <div class="col-4 border-end">
                            <span>Humidity</span>
                            <div class="text-dark fw-bold fs-6">{{ $weatherData['humidity'] }}%</div>
                        </div>
                        <div class="col-4">
                            <span>Wind Speed</span>
                            <div class="text-dark fw-bold fs-6">{{ $weatherData['wind_speed'] }} m/s</div>
                        </div>
                    </div>
                @else
                    <!-- Fallback Message -->
                    <div class="alert alert-warning mb-0 mt-2">
                        <strong>Weather Information Unavailable</strong><br>
                        {{ $weatherError ?? 'Unable to retrieve weather data at this moment.' }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="col-md-3">
        <div class="card text-white shadow-sm h-100 border-0" style="background-color: #198754; border-radius: 12px;">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <h2 class="display-6 fw-bold">₱{{ number_format($todaySales ?? 0, 2) }}</h2>
                <p class="mb-0 fw-semibold">Today's Total Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white shadow-sm h-100 border-0" style="background-color: #0d6efd; border-radius: 12px;">
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <h2 class="display-6 fw-bold">{{ $totalProducts ?? 0 }}</h2>
                <p class="mb-0 fw-semibold">Total Products</p>
            </div>
        </div>
    </div>
</div>

<!-- Low Stock Alerts -->
<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-header bg-danger text-white fw-bold">
        Low Stock Alerts (Action Required)
    </div>
    <div class="card-body">
        @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td><span class="badge bg-danger">{{ $product->stock_quantity }}</span></td>
                        <td>{{ $product->reorder_threshold }}</td>
                        <td><a href="{{ route('admin.stock_in.create') }}" class="btn btn-sm btn-outline-primary">Restock</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-success mb-0">All inventory levels are sufficient.</p>
        @endif
    </div>
</div>
@endsection