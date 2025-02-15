<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class GoogleMapsService
{
    public function getDistanceDuration(array $data): JsonResponse
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($data['address_from']) . "&destinations=" . urlencode($data['address_to']) . "&key=" . env('GOOGLE_MAPS_API_KEY');
        $response = Http::get($url);
        $data = $response->json();
        if ($response->successful()) {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            $duration = $data['rows'][0]['elements'][0]['duration']['text'];
            return response()->json([
                'distance' => $distance,
                'duration' => $duration
            ]);
        } else {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }

}
