<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0"
 * ),
 * 
 * @OA\SecurityScheme(
 *     securityScheme="Sanctum Auth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Введите токен в формате 'Bearer {your-token}'"
 * ),
 * 
 * @OA\PathItem(
 *     path="/api/"
 * )
 * 
 */
class MainController extends Controller
{
    
}
