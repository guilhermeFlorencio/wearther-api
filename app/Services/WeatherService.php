<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherFetchException;

class WeatherService
{
    private WeatherApiService $apiService;

    public function __construct(WeatherApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getWeatherData(string $city): array
    {
        return Cache::remember("weather-{$city}", now()->addHour(), function () use ($city) {
            try {
                $location = $this->apiService->fetch('geo/1.0/direct', [
                    'q' => $city,
                    'limit' => 1,
                ]);

                if (empty($location)) {
                    throw new CityNotFoundException();
                }

                $lat = $location[0]['lat'];
                $lon = $location[0]['lon'];

                $data = $this->apiService->fetch('data/3.0/onecall', [
                    'lat' => $lat,
                    'lon' => $lon,
                    'units' => 'metric',
                    'lang' => 'pt',
                    'exclude' => 'minutely',
                ]);

                return [
                    'current' => $this->apiService->formatCurrentWeather($data['current'])->toArray(),
                    'daily' => array_map(fn($day) => $day->toArray(), $this->apiService->formatDailyWeather($data['daily'])),
                ];
            } catch (\Exception $e) {
                if ($e->getCode() === 404) {
                    throw new CityNotFoundException();
                }
                throw new WeatherFetchException();
            }
        });
    }
}


