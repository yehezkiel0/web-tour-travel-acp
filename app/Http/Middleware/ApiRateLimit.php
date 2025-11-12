<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimit
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @param string $maxAttempts
   * @param string $decayMinutes
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle($request, $next, $maxAttempts = '60', $decayMinutes = '1')
  {
    $key = 'api:' . $request->ip() . ':' . ($request->user()?->id ?? 'guest');

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      return response()->json([
        'success' => false,
        'message' => 'Too many attempts. Please try again later.',
        'retry_after' => RateLimiter::availableIn($key),
      ], Response::HTTP_TOO_MANY_REQUESTS);
    }

    RateLimiter::hit($key, $decayMinutes);

    $response = $next($request);

    // Add rate limit headers
    $response->headers->set('X-RateLimit-Limit', $maxAttempts);
    $response->headers->set('X-RateLimit-Remaining', max(0, $maxAttempts - RateLimiter::attempts($key)));
    $response->headers->set('X-RateLimit-Reset', RateLimiter::availableIn($key));

    return $response;
  }
}
