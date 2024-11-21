<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DataTransferObjects\CurrentWeatherDTO;
use App\DataTransferObjects\DailyWeatherDTO;

class WeatherApiService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function fetch(string $endpoint, array $params = [])
    {
        $url = $this->baseUrl . $endpoint;
        $params['appid'] = $this->apiKey;

        $response = Http::get($url, $params);

        $response->throw();
        return $response->json();
    }

    public function formatCurrentWeather(array $currentData): CurrentWeatherDTO
    {
        return new CurrentWeatherDTO(
            $currentData['temp'],
            ucfirst($currentData['weather'][0]['description']),
            $currentData['humidity'] . '%',
            $currentData['wind_speed'] . ' m/s',
        );
    }

    public function formatDailyWeather(array $dailyData): array
    {
        return array_map(function ($day) {
            return new DailyWeatherDTO(
                date('Y-m-d', $day['dt']),
                [
                    'min' => $day['temp']['min'] . '°C',
                    'max' => $day['temp']['max'] . '°C',
                ],
                ucfirst($day['weather'][0]['description']),
            );
        }, $dailyData);
    }
}


