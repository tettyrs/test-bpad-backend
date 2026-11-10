<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Responses\ApiError;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private const TOKEN_TTL_HOURS = 24;

    private const DUMMY_HASH = '$2y$12$uwSI2cbyP9nlqnG.mhf5l.xkAObQi7.n5t.ICbUdSL.9uoJH52dxa';

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        $passwordValid = Hash::check($credentials['password'], $user?->password ?? self::DUMMY_HASH);

        if (! $user || ! $passwordValid || ! $user->is_active) {
            return ApiError::make('INVALID_CREDENTIALS', 'Email atau password salah.', 401);
        }

        $token = $user->createToken('api', ['*'], now()->addHours(self::TOKEN_TTL_HOURS));

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'expires_in' => self::TOKEN_TTL_HOURS * 3600,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => ['message' => 'Logout berhasil.'],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }
}
