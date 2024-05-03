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

    public function check()
    {
        if (auth()->check()) {
            return response()->json(['success' => true, 'mensagem' => 'Usuário autenticado'], Response::HTTP_OK);
        }

        return response()->json(['success' => true, 'mensagem' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
    }



    public function loginFirebase(Request $request, User $user)
    {
        try {
            $name = explode("@", $request->email)[0];

            if(!$user->first('email', $request->email)) {
                $user->uuid = $request->id;
                $user->name = $name;
                $user->email = $request->email;
                $user->provider = $request->provider;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'success',
                'user' => [
                    'name' => $name
                ],
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'request' => $request->id
            ], 500);
        }
    }
}
