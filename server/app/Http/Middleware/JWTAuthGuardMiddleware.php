<?php

namespace App\Http\Middleware;

use App\Http\Response\ApiResponseError;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return new ApiResponseError($e, 'Token is expired', Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException  $e) {
            return new ApiResponseError($e, 'Invalid token', Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return new ApiResponseError($e, 'Invalid token', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
