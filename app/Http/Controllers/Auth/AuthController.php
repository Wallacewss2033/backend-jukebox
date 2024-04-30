<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'errors'  => [
                    'Credenciais inválidas'
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'user' => [
                'name' => auth()->user()->name
            ],
            'authorization' => [
                'token' => auth()->user()->createToken('auth-token')->plainTextToken,
                'type' => 'bearer',
            ]
        ], Response::HTTP_OK);
    }

    public function logout()
    {

        if (auth()->user()) {
            auth()->user()->tokens()->delete();
            return response([], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not found',
            'errors' => [
                'Usuário não encontrado'
            ]
        ], Response::HTTP_NOT_FOUND);
    }
}
