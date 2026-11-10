<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiError;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            return ApiError::make('FORBIDDEN', 'Hanya admin yang boleh melakukan aksi ini.', 403);
        }

        return $next($request);
    }
}
