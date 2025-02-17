<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleMaps\DistanceDurationRequest;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;

class GoogleMapsController extends Controller
{
    public function __construct(public GoogleMapsService $googleMapsService)
    {
    }

    public function distanceDuration(DistanceDurationRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->googleMapsService->getDistanceDuration($request->validated());
    }

    public function coordinates(DistanceDurationRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->googleMapsService->getCoordinates($request->validated());
    }
}
