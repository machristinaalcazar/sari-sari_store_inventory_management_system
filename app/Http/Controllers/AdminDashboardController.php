<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller {
    public function index(Request $request) {
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_threshold')->get();
        $totalProducts = Product::count();
        $todaySales = Sale::whereDate('created_at', now()->today())->sum('total_amount');

        // Kunin ang pinalitang city kung nag-search ang user, o gamitin ang default sa .env
        $defaultCity = config('services.openweather.city', env('OPENWEATHER_CITY', 'Arakan'));
        $searchCity = $request->input('city', $defaultCity);

        $apiKey = config('services.openweather.key', env('OPENWEATHER_API_KEY'));
        
        $weatherData = null;
        $weatherError = null;

        if ($apiKey) {
            try {
                // HTTP Client with 5-second timeout requirement
                $response = Http::timeout(5)->get('https://api.openweathermap.org/data/2.5/weather', [
                    'q' => $searchCity,
                    'appid' => $apiKey,
                    'units' => 'metric'
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $weatherData = [
                        'city' => $json['name'] ?? $searchCity,
                        'country' => $json['sys']['country'] ?? '',
                        'temp' => round($json['main']['temp'] ?? 0, 1),
                        'feels_like' => round($json['main']['feels_like'] ?? 0, 1),
                        'condition' => $json['weather'][0]['description'] ?? 'N/A',
                        'icon' => $json['weather'][0]['icon'] ?? '02d', // Default cloud icon
                        'humidity' => $json['main']['humidity'] ?? 'N/A',
                        'wind_speed' => $json['wind']['speed'] ?? 'N/A',
                    ];
                } else {
                    $weatherError = 'City "' . e($searchCity) . '" not found or API error.';
                }
            } catch (\Exception $e) {
                Log::error('Weather API Connection Error: ' . $e->getMessage());
                $weatherError = 'Weather service is currently unavailable. Connection timed out.';
            }
        } else {
            $weatherError = 'Weather API Key is not configured in the .env file.';
        }

        return view('admin.dashboard', compact('lowStockProducts', 'totalProducts', 'todaySales', 'weatherData', 'weatherError', 'searchCity'));
    }
}