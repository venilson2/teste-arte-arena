<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class AuthenticatedSessionController extends Controller
{

    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();
        $user = Auth::user();

        $key = env('JWT_SECRET');
        $payload = [
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'sub' => $user->id,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return response()->json([
            'token' => $jwt,
            'user' => $user
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        // Remove o token atual
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
