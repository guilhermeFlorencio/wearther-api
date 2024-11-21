<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\WeatherService;
use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherFetchException;

class WeatherController extends Controller
{
    private WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather(Request $request)
    {
        $city = $request->query('city');

        if (!$city) {
            return response()->json(['error' => 'É necessário informar a cidade'], 400);
        }
        
        try {
            $weatherData = $this->weatherService->getWeatherData($city);
            return response()->json($weatherData);
        } catch (CityNotFoundException $e) {
            Log::warning("Cidade não encontrada: {$city}");
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (WeatherFetchException $e) {
            Log::error("Erro ao buscar dados meteorológicos para a cidade: {$city}");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}


