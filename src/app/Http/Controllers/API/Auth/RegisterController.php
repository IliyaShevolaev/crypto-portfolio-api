<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $registerRequest) 
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
