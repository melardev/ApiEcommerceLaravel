<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Facades\Log;

use Closure;
use Illuminate\Session\TokenMismatchException;


class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'subscribe',
        'subscribe/*',
        'stripe/*'
    ];

    public function handle($request, Closure $next)
    {
        Log::info("Looking for token");

        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->shouldPassThrough($request) ||
            $this->tokensMatch($request)
        ) {
            Log::info("Looking for token here 1");
            return $this->addCookieToResponse($request, $next($request));
        }

        throw new TokenMismatchException;
    }

}
