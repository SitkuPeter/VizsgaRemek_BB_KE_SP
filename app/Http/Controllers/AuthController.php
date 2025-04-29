<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function generateToken(Request $request)
    {
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
}