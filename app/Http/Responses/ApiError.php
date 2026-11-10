<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class ApiError
{
    public static function make(string $code, string $message, int $status, mixed $details = null): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
            ],
        ], $status);
    }
}
