<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Agregar el rol al JWT (payload del token)
        $customClaims = [
            'role' => auth()->user()->role,  // Aquí agregamos el campo 'role' del usuario
        ];

        $token = JWTAuth::claims($customClaims)->attempt($credentials);

        return JsonResponse([
            'token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return JsonResponse(message: 'Successfully logged out');
    }
}
