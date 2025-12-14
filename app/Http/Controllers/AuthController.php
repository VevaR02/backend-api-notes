<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->name || !$request->email || !$request->password) {
            return response()->json(['status' => 'fail', 'message' => 'Data tidak lengkap'], 400);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['status' => 'fail', 'message' => 'Email sudah terdaftar'], 400);
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['status' => 'success', 'message' => 'User berhasil dibuat'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => 'Server Error'], 500);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Email tidak ditemukan'], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'fail', 'message' => 'Password salah'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'accessToken' => $token,
                'name' => $user->name
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }
}