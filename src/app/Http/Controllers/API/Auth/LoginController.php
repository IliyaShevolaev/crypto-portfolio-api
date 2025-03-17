<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest) : JsonResponse
    {
        $loginData = $loginRequest->validated();

        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            $token = $user->createToken('API Access Token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout() : JsonResponse
    {
        $user = Auth::user();

        $currentToken = $user->currentAccessToken();
        $user->tokens()->where('id', $currentToken->id)->delete();

        return response()->json(['message' => 'logout'], 200);
    }

    public function absoluteLogOut() : JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['message' => 'logout'], 200);
    }
}
