<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;


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

    public function check()
    {
        if (auth()->check()) {
            return response()->json(['success' => true, 'mensagem' => 'Usuário autenticado'], Response::HTTP_OK);
        }

        return response()->json(['success' => true, 'mensagem' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
    }



    public function loginFireBase(Request $request, User $user)
    {
        try {
            $auth = Firebase::auth();
            $verify = $auth->verifyIdToken($request->bearerToken());
            if ($verify) {
                $name = explode("@", $request->email)[0];
                $userAuth = $user->firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $name,
                        'email' => $request->email,
                        'provider' => $request->provider,
                        'password' => Hash::make($request->password)
                    ]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'success',
                    'user' => [
                        'name' => $userAuth->name
                    ],
                    'authorization' => [
                        'token' => $userAuth->createToken('auth-token')->plainTextToken,
                        'type' => 'bearer',
                    ]
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
