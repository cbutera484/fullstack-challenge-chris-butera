<?php
// app/Services/WeatherService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;
    protected $endpoint = 'https://api.openweathermap.org/data/2.5/weather'; //TODO make this configurable

    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.key');
    }

    public function getWeatherByCoordinates(float $lat, float $lon): ?array
    {
        $cacheKey = "weather:{$lat}:{$lon}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($lat, $lon) {
            try {
                $response = Http::timeout(1)->get($this->endpoint, [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $this->apiKey,
                    'units' => 'imperial',
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning('Failed weather fetch', ['lat' => $lat, 'lon' => $lon, 'status' => $response->status()]);
            } catch (\Exception $e) {
                Log::error('Weather API exception', ['error' => $e->getMessage()]);
            }

            return null; // fallback if API fails
        });
    }
}
