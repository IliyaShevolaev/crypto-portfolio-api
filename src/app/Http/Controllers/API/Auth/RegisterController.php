<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $registerRequest) : JsonResponse
    {
        $registerData = $registerRequest->validated();

        $newUser = User::create([
            'name' => $registerData['name'],
            'email' => $registerData['email'],
            'password' => Hash::make($registerData['password']),
        ]);

        $token = $newUser->createToken('API Access Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
