<?php

namespace App\Http\Middleware;


use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    // php artisan make:middleware JwtMiddleware
    public function handle($request, Closure $next, $optional = null)
    {

        try {
            // $user = JWTAuth::parseToken()->authenticate();
            if (!$user = $this->auth->parseToken('token')->authenticate()) {
                return response()->json(['success' => false, 'full_messages' => ['JWT error: User not found']]);
            }
        } catch (TokenExpiredException $ex) {
            return response()->json(['success' => false, 'full_messages' => ['Expired token']]);
        } catch (TokenInvalidException $e) {
            return response()->json(['success' => false, 'full_messages' => ['Invalid Token']]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'full_messages' => ['Error on token, have you provided a token']]);
        }

        return $next($request);
    }

    protected function respondError($message)
    {
        return response()->json([
            'errors' => [
                'message' => $message,
                'status_code' => 401
            ]
        ], 401);
    }
}
