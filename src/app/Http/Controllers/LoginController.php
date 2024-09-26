<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(LoginRequest $request): JsonResource|JsonResponse
    {
        // Store the credentials from request
        $credentials = $request->only('email', 'password');
        
        // Attempt to authenticate
        if (Auth::attempt($credentials)) {
            // Store the current user
            $user = Auth::user();
            
            // Creating new Sanctum token
            $tokenResult = $user->createToken('api_access_token_sanctum');
            $token = $tokenResult->plainTextToken;
            
            // Set token expiration
            $expires_at = now()->addHours(12);
            $tokenResult->accessToken->expires_at = $expires_at;
            $tokenResult->accessToken->save();

            // Data to return
            $data = (object) [
                "id" => $user->id,
                "name"=> $user->name,
                "email"=> $user->email,
                "token" => "Bearer {$token}",
                "exp" => $expires_at
            ];
            
            // Return the data from login
            return new UserResource($data);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
 
    }
}
