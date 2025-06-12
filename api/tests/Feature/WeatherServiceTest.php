<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;

class WeatherServiceTest extends TestCase
{
    public function test_it_fetches_weather_from_api_and_caches_response()
    {
        $lat = 40.7128;
        $lon = -74.0060;

        $fakeResponse = [
            'weather' => [['description' => 'clear sky']],
            'main' => ['temp' => 70.5],
        ];

        Http::fake([
            'api.openweathermap.org/*' => Http::response($fakeResponse, 200),
        ]);

        Cache::shouldReceive('remember')
            ->once()
            ->with("weather:$lat:$lon", \Mockery::type('Illuminate\Support\Carbon'), \Mockery::on(function ($closure) use ($fakeResponse) {
                $result = $closure();
                return $result === $fakeResponse;
            }))
            ->andReturn($fakeResponse);

        $service = new WeatherService();
        $result = $service->getWeatherByCoordinates($lat, $lon);

        $this->assertSame($fakeResponse, $result);
    }


    /** TODO:would add a test for error scenario */
}
