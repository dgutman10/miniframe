<?php

namespace App;

use App\Http\Request;

class Kernel
{
    /** @var MiddlewareStack */
    private $middlewareStack;

    /** @var Request */
    private $requestHandler;

    /**
     * Kernel constructor.
     * @param MiddlewareStack $middlewareStack
     * @param Request $request
     */
    public function __construct(MiddlewareStack $middlewareStack, Request $request)
    {
        $this->middlewareStack = $middlewareStack;
        $this->requestHandler = $request;
    }

    /**
     * @param Middleware\MiddlewareInterface $middleware
     */
    public function addMiddleware(Middleware\MiddlewareInterface $middleware)
    {
        $this->middlewareStack->add($middleware);
    }

    /**
     * Run Application
     */
    public function run()
    {
        $this->middlewareStack->handle($this->requestHandler);
    }
}