<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateFormRequest;

class ValidateController extends Controller
{
    public function validateCalculateForm(CalculateFormRequest $request)
    {

        return response()->json(['message' => 'Success',], 200);

    }
}
