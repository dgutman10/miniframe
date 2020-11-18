<?php


namespace App\Middleware;


use App\Http\JsonResponse;
use App\Http\RequestInterface;

class AuthorizationCheck implements MiddlewareInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(RequestInterface $request, Callable $next)
    {
        if ( $request->header('Authorization') != "Bearer token") {
            return JsonResponse::create("Authorization fail", 401);
        }

        return $next($request);
    }
}