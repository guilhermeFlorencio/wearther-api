<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherApiService
{
    public static function getBaseUrl(): string
    {
        return config('app.weather_api_url');
    }

    public static function getApiKey(): string
    {
        return config('app.weather_api_key');
    }

    public static function fetch(string $endpoint, array $params = [])
    {
        $url = self::getBaseUrl() . $endpoint;
        $params['appid'] = self::getApiKey();

        $response = Http::get($url, $params);

        $response->throw();
        return $response->json();
    }

    public static function formatCurrentWeather(array $currentData): array
    {
        return [
            'temperature' => $currentData['temp'],
            'description' => ucfirst($currentData['weather'][0]['description']),
            'humidity' => $currentData['humidity'] . '%',
            'wind_speed' => $currentData['wind_speed'] . ' m/s',
        ];
    }

    public static function formatDailyWeather(array $dailyData): array
    {
        return array_map(function ($day) {
            return [
                'date' => date('Y-m-d', $day['dt']),
                'temperature' => [
                    'min' => $day['temp']['min'] . '°C',
                    'max' => $day['temp']['max'] . '°C',
                ],
                'description' => ucfirst($day['weather'][0]['description']),
            ];
        }, $dailyData);
    }
}
