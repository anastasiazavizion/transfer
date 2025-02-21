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

    private function getAddressInfo(string $from, string $to)
    {
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($from) . "&destination=" . urlencode($to) . "&avoid=tolls&key=" . env('GOOGLE_MAPS_API_KEY');
        $response = file_get_contents($url);
        $result = json_decode($response, true);
        if (!empty($result['routes'])) {
            $route = $result['routes'][0];
            $leg = $route['legs'][0];
            $distance = $leg['distance']['text'];
            $duration = $leg['duration']['text'];
            return [
                'distance' => $distance,
                'duration' => $duration
            ];
        }else{
            return false;
        }
    }

    function convertToKilometers($distanceString) {
        // Remove any commas from the distance string
        $distanceString = str_replace(',', '', $distanceString);

        $distance = 0;

        // Check if the distance is in meters and convert to kilometers
        if (preg_match('/(\d+)\s*m/', $distanceString, $matches)) {
            $distance = $matches[1] * 0.001;  // Convert meters to kilometers
        }
        // Check if the distance is in kilometers (no conversion needed)
        elseif (preg_match('/(\d+)\s*km/', $distanceString, $matches)) {
            $distance = $matches[1];  // Directly use the kilometers value
        }

        return $distance;
    }

    private function getTotal(string $distance1,string $distance2, string $distance3) : float
    {

        $total = $this->convertToKilometers($distance1) * config('map.price_per_1_km_to_location1') +
            $this->convertToKilometers($distance2) * config('map.price_per_1_km_to_location2') +
            $this->convertToKilometers($distance3) * config('map.price_per_1_km_to_location3');

        return round($total,2);
    }

    public function getDistanceDuration(array $data): JsonResponse
    {
        $location1 = $this->getAddressInfo(config('map.home_address'), $data['address_from']);
        $location2 = $this->getAddressInfo($data['address_from'], $data['address_to']);
        $location3 = $this->getAddressInfo($data['address_to'],config('map.home_address'));

        if($location1 && $location2 && $location3){

            $distance1 = $location1['distance'];
            $distance2 = $location2['distance'];
            $distance3 = $location3['distance'];

            $total = $this->getTotal($distance1, $distance2, $distance3);

            return response()->json([
                'distance' => $distance2,
                'distance1'=>$distance1,
                'distance3'=>$distance3,
                'duration' => $location2['duration'],
                'total'=>$total
            ]);

        }else{
            return response()->json(['message' => 'Not found'], 404);
        }

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
