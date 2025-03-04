<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        return StatusResource::collection(Status::all());
    }
}
