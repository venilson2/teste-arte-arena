<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends Controller
{

    public function store(LoginRequest $request): JsonResponse
    {
        // Extrai as credenciais do request (email e senha)
        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário e gerar um token JWT
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retorna o token JWT e o usuário autenticado
        return response()->json([
            'token' => $token,
            'user' => auth()->user()
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        // Remove o token atual
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
