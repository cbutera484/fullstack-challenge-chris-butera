<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index(): JsonResponse
    {
        $users = User::all()->map(function ($user) {
            $weather = $this->weatherService->getWeatherByCoordinates($user->latitude, $user->longitude);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'weather' => $weather ? [
                    'description' => $weather['weather'][0]['description'] ?? null,
                    'temp' => $weather['main']['temp'] ?? null,
                    'icon' => $weather['weather'][0]['icon'] ?? null,
                ] : null,
            ];
        });

        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $weather = $this->weatherService->getWeatherByCoordinates($user->latitude, $user->longitude);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'latitude' => $user->latitude,
            'longitude' => $user->longitude,
            'weather' => $weather ?? null,
        ]);
    }
}
