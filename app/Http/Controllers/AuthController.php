<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $credentials = request(['email', 'password']);
            $credentials['is_admin'] = 0;
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Credentials do not match'
                ], 422);
            }
            $user = User::where('email', $request->email)
                ->where('is_login', 1)
                ->where('is_active', 1)
                ->first();

            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
            ]);

            return response()->json(['status' => true, 'message' => "Logged Successfully !!", 'token' => $token, 'data' => $user,], 200);
        } catch (\Exception $exception) {
            \Log::debug($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
}
