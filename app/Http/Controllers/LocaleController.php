<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function translations(): JsonResponse
    {
        $enPath = base_path('/lang/en.json');
        $enData = json_decode(file_get_contents($enPath), true);
        $uaPath = base_path('/lang/ua.json');
        $uaData = json_decode(file_get_contents($uaPath), true);
        $esPath = base_path('/lang/es.json');
        $esData = json_decode(file_get_contents($esPath), true);
        $messages = [
            'en' => $enData,
            'ua' => $uaData,
            'es' => $esData,
        ];
        return response()->json($messages);
    }

    public function store(string $locale): JsonResponse
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return response()->json($locale);
    }

    public function currentLocale(): JsonResponse
    {
        $locale = session()->get('locale', app()->getLocale());
        return response()->json($locale);
    }
}
