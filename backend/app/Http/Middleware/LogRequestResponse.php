<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Audit;

class LogRequestResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $requestId = $request->header('X-Request-Id') ?? (string) Str::uuid();
        $request->headers->set('X-Request-Id', $requestId);

        // Filter sensitive fields
        $payload = $request->except(['password', 'password_confirmation', 'token', 'authorization', 'access_token']);

        try {
            $response = $next($request);
        } catch (\Throwable $th) {
            // still log the request with error
            Log::error('Request handling failed: ' . $th->getMessage(), ['request_id' => $requestId]);
            throw $th;
        }

        $duration = (microtime(true) - $start) * 1000;

        try {
            Audit::create([
                'user_id'    => optional($request->user())->id,
                'request_id' => $requestId,
                'method'     => $request->method(),
                'route'      => $request->route()?->getName() ?? $request->path(),
                'path'       => $request->path(),
                'ip'         => $request->ip(),
                'request'    => $payload,
                'status'     => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
                'response'   => is_string($response->getContent() ?? null) ? mb_substr($response->getContent(), 0, 2000) : null,
                'meta'       => ['user_agent' => $request->userAgent(), 'duration_ms' => (int)$duration],
            ]);
        } catch (\Throwable $th) {
            // Prevent logging failures from breaking the request
            Log::error('Audit save failed: ' . $th->getMessage(), ['request_id' => $requestId]);
        }

        // Ensure response contains the request id header for correlation
        if (method_exists($response, 'headers')) {
            $response->headers->set('X-Request-Id', $requestId);
        }

        return $response;
    }
}
