<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
            ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles('masyarakat');

        $token = $user->createToken('auth_token')->plainTextToken;

        return (new UserResource($user))->additional([
            'message' => 'Akun berhasil dibuat',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid login',
            ], 401);
            }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return (new UserResource($user))->additional([
            'message' => 'Akun berhasil dibuat',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Akun dan semua data sesi Anda telah dihapus secara permanen.'
        ], 200);
    }
}

