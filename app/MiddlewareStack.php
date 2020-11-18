<?php


namespace App;


use App\Http\Request;
use App\Http\RequestInterface;
use Closure;

class MiddlewareStack
{
    /**
     * @var Closure
     */
    private $stack;

    /**
     * MiddlewareStack constructor.
     */
    public function __construct()
    {
        $this->stack = function (RequestInterface $request) {
            return $request->handle();
        };
    }

    /**
     * Add middleware to stack
     * @param callable $middleware
     */
    public function add(Callable $middleware)
    {
        $next = $this->stack;

        $this->stack = function(Request $request) use ($middleware, $next) {
            return $middleware($request, $next);
        };
    }

    /**
     * @param RequestInterface $request
     * @return Request
     */
    public function handle(RequestInterface $request)
    {
        return call_user_func($this->stack, $request);
    }
}