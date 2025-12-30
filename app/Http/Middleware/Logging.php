<?php

namespace App\Http\Middleware;

use App\Helpers\ApiFormatter;
use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = null;
        }

        $filteredRequest = ApiFormatter::filterSensitiveData($request->all());

        $log = Log::create([
            'user_id' => $user ? $user->id : null,
            'log_method' => $request->method(),
            'log_url' => $request->fullUrl(),
            'log_ip' => $request->ip(),
            'log_request' => json_encode($filteredRequest),
        ]);

        try {
            $response = $next($request);

            $log->update([
                'log_response' => $response->getContent(),
            ]);

            return $response;
        } catch (Throwable $e) {
            $errorResponse = ApiFormatter::createJson(
                500,
                'Internal Server Error',
                $e->getMessage()
            );

            $log->update([
                'log_response' => response()->json($errorResponse, 500)->getContent(),
            ]);

            return response()->json($errorResponse, 500);
        }
    }
}
