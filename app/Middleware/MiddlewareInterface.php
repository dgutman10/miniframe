<?php


namespace App\Middleware;


use App\Http\RequestInterface;

interface MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param Callable $next
     * @return mixed
     */
    public function __invoke(RequestInterface $request, Callable $next);
}