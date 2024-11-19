<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\WeatherApiService;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->query('city');
    
        if (!$city) {
            return response()->json(['error' => 'City is required'], 400);
        }
    
        $cachedWeather = Cache::get("weather-{$city}");
        if ($cachedWeather) {
            return response()->json($cachedWeather);
        }
    
        try {
            $location = WeatherApiService::fetch('geo/1.0/direct', [
                'q' => $city,
                'limit' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'City not found'], 404);
        }
    
        if (empty($location)) {
            return response()->json(['error' => 'City not found'], 404);
        }
    
        $lat = $location[0]['lat'];
        $lon = $location[0]['lon'];
    
        try {
            $data = WeatherApiService::fetch('data/3.0/onecall', [
                'lat' => $lat,
                'lon' => $lon,
                'units' => 'metric',
                'lang' => 'pt',
                'exclude' => 'minutely',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch weather data'], 500);
        }
    
        $formattedWeather = [
            'current' => WeatherApiService::formatCurrentWeather($data['current']),
            'daily' => WeatherApiService::formatDailyWeather($data['daily']),
        ];
    
        Cache::put("weather-{$city}", $formattedWeather, now()->addHour());
    
        return response()->json($formattedWeather);
    }
}
