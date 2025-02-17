<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login() {
        $credentials = request(['email', 'password']);

        if( !$token = auth()->attempt($credentials) ) {
            return response()->json(['error' => '認証に失敗しました'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'ログアウトしました'], 200);
    }

    public function me() {
        return response()->json(auth()->user(), 200);
    }

    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
