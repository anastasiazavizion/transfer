<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Http\Request;

class UserController
{
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json(['user'=>new CurrentUserResource($user)]);
    }
}
