<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'name' => [trans('auth.failed')],
            ]);
        }

        $user = User::where('name', $request->name)->firstOrFail();

        $token = $user->createToken('auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth-token');

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token->plainTextToken,
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'sometimes|string|unique:users,name,' . $user->id,
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|confirmed',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
