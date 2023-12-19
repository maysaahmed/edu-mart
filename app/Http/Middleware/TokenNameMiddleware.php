<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenNameMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @param mixed ...$tokenNames
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$tokenNames): mixed
    {
        $user = $request->user();
        if (! $user || ! in_array($user->currentAccessToken()->name, $tokenNames)) {

           return $this->errorResponse('Unauthorized', Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
