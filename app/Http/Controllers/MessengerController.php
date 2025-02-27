<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessengerResource;
use App\Models\Messenger;

class MessengerController extends Controller
{
    public function index()
    {
        return MessengerResource::collection(Messenger::all());
    }

}
