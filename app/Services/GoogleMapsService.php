<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class GoogleMapsService
{
    private function decodePolyline($encoded): array
    {
        $points = [];
        $index = 0;
        $len = strlen($encoded);
        $lat = 0;
        $lng = 0;

        while ($index < $len) {
            // Decode latitude
            $shift = 0;
            $result = 0;
            do {
                $b = ord($encoded[$index]) - 63;
                $index++;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);
            $lat += ($result & 1) ? ~($result >> 1) : ($result >> 1);

            // Decode longitude
            $shift = 0;
            $result = 0;
            do {
                $b = ord($encoded[$index]) - 63;
                $index++;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);
            $lng += ($result & 1) ? ~($result >> 1) : ($result >> 1);
            // Store the decoded lat/lng points
            $points[] = [($lat / 1E5), ($lng / 1E5)];
        }
        return $points;
    }

    public function getCoordinates(array $data) : JsonResponse
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($data['address_from']) . "&destination=" . urlencode($data['address_to']) . "&key=" . env('GOOGLE_MAPS_API_KEY');
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['routes'][0]['legs'][0]['steps'])) {
            $polylineCoordinates = [];
            // Loop through steps and decode polyline
            foreach ($data['routes'][0]['legs'][0]['steps'] as $step) {
                $encodedPolyline = $step['polyline']['points'];
                // Decode the polyline using the Google Maps encoding algorithm
                $decodedPolyline = $this->decodePolyline($encodedPolyline);
                // Add decoded points to the coordinates array
                foreach ($decodedPolyline as $point) {
                    $polylineCoordinates[] = ['lat' => $point[0], 'lng' => $point[1]];
                }
            }

            return response()->json([
                'coordinates' => $polylineCoordinates,
            ]);

        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

    }

    public function getDistanceDuration(array $data): JsonResponse
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($data['address_from']) . "&destination=" . urlencode($data['address_to']) . "&key=" . env('GOOGLE_MAPS_API_KEY');
        $response = file_get_contents($url);
        $result = json_decode($response, true);
        if (!empty($result['routes'])) {
            $route = $result['routes'][0];
            $leg = $route['legs'][0];
            $distance = $leg['duration']['text'];
            $duration = $leg['distance']['text'];
            return response()->json([
                'distance' => $distance,
                'duration' => $duration,
            ]);
        }else{
            return response()->json(['message' => 'Not found'], 404);
        }
    }

}
