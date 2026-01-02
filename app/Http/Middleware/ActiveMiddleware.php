<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ApiFormatter;

class ActiveMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(
                ApiFormatter::createJson(401, 'Token tidak valid'),
                401
            );
        }

        // Admin bebas
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Mahasiswa belum aktif → blok
        if ($user->role === 'mahasiswa' && $user->is_active == 0) {

            // Masih boleh lihat profil
            if ($request->is('api/profile')) {
                return $next($request);
            }

            return response()->json(
                ApiFormatter::createJson(403, 'Akun anda belum diaktifkan admin'),
                403
            );
        }

        return $next($request);
    }
}
