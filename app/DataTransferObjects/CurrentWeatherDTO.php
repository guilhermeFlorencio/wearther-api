<?php

namespace App\DataTransferObjects;

class CurrentWeatherDTO
{
    public function __construct(
        public float $temperature,
        public string $description,
        public string $humidity,
        public string $wind_speed,
    ) {}

    public function toArray(): array
    {
        return [
            'temperature' => $this->temperature,
            'description' => $this->description,
            'humidity' => $this->humidity,
            'wind_speed' => $this->wind_speed,
        ];
    }
}
