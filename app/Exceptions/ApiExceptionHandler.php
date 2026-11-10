<?php

namespace App\Exceptions;

use App\Http\Responses\ApiError;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class ApiExceptionHandler
{
    public static function render(Throwable $e, Request $request): ?JsonResponse
    {
        if (! $request->is('api/*')) {
            return null;
        }

        return match (true) {
            $e instanceof ConflictException => ApiError::make(
                'CONFLICT',
                $e->getMessage(),
                409,
            ),

            $e instanceof ValidationException => ApiError::make(
                'VALIDATION_ERROR',
                'Data yang dikirim tidak valid.',
                422,
                $e->errors(),
            ),

            $e instanceof AuthenticationException => ApiError::make(
                'UNAUTHENTICATED',
                'Token tidak valid atau belum login.',
                401,
            ),

            $e instanceof AuthorizationException => ApiError::make(
                'FORBIDDEN',
                'Anda tidak memiliki akses ke resource ini.',
                403,
            ),

            self::isModelNotFound($e) => ApiError::make(
                'RESOURCE_NOT_FOUND',
                'Data yang diminta tidak ditemukan.',
                404,
            ),

            $e instanceof NotFoundHttpException => ApiError::make(
                'ENDPOINT_NOT_FOUND',
                'Endpoint yang diminta tidak ditemukan.',
                404,
            ),

            $e instanceof QueryException && self::isDuplicateEntry($e) => ApiError::make(
                'CONFLICT',
                'Data bentrok dengan data yang sudah ada.',
                409,
            ),

            $e instanceof HttpExceptionInterface => self::fromHttpException($e),

            default => ApiError::make(
                'INTERNAL_ERROR',
                'Terjadi kesalahan pada server.',
                500,
                config('app.debug') ? [
                    'exception' => $e::class,
                    'message' => $e->getMessage(),
                ] : null,
            ),
        };
    }

    private static function fromHttpException(HttpExceptionInterface $e): JsonResponse
    {
        $status = $e->getStatusCode();

        $code = match ($status) {
            405 => 'METHOD_NOT_ALLOWED',
            415 => 'UNSUPPORTED_MEDIA_TYPE',
            429 => 'TOO_MANY_REQUESTS',
            default => 'HTTP_'.$status,
        };

        $message = match ($status) {
            405 => 'Method HTTP tidak diizinkan untuk endpoint ini.',
            429 => 'Terlalu banyak permintaan. Coba lagi beberapa saat.',
            default => $e instanceof HttpException && $e->getMessage() !== ''
                ? $e->getMessage()
                : 'Permintaan tidak dapat diproses.',
        };

        return ApiError::make($code, $message, $status);
    }

    private static function isModelNotFound(Throwable $e): bool
    {
        return $e instanceof ModelNotFoundException
            || ($e instanceof NotFoundHttpException && $e->getPrevious() instanceof ModelNotFoundException);
    }

    private static function isDuplicateEntry(QueryException $e): bool
    {
        return ($e->errorInfo[1] ?? null) === 1062;
    }
}
