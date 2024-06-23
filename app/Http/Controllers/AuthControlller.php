<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControlller extends Controller
{
    //Register Controller
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|lowercase|unique:users,username',
            'email' => 'required|max:255|email|lowercase|unique:users,email',
            'password' => 'required|max:255',
        ]);

        $user = User::create($validated);

        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user
            ], 201);
        }
        return response()->json([
            'status' => false
        ], 409);
    }

    //Login Controller
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|lowercase|max:255',
            'password' => 'required'
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'username atau password salah'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'token' => $user->createToken($user->username, ['*'], now()->addMinutes(30))->plainTextToken
        ], 200);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true
        ], 200);
    }
}
