<?php

namespace App\DataTransferObjects;

class DailyWeatherDTO
{
    public function __construct(
        public string $date,
        public array $temperature,
        public string $description,
    ) {}

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'temperature' => $this->temperature,
            'description' => $this->description,
        ];
    }
}
