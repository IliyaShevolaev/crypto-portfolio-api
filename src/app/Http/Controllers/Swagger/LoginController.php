<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 */
class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Authenticate user and return token",
     *     tags={"Authentication"},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     * 
     *     @OA\Response(response=200, description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="some-generated-token")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(LoginRequest $loginRequest)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout user by deleting current access token",
     *     tags={"Authentication"},
     *     security={{"SanctumAuth":{}}},
     * 
     *     @OA\Response(response=200, description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="logout")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout-all",
     *     summary="Logout user from all devices by deleting all access tokens",
     *     tags={"Authentication"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Response(response=200, description="Successful absolute logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="logout")
     *         )
     *     )
     * )
     */
    public function absoluteLogOut()
    {
        //
    }
}
