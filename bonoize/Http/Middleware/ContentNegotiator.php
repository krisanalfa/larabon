<?php namespace Bonoize\Http\Middleware;

use Bonoize\Handler;
use Bonoize\RouterHelper;
use Closure;
use InvalidArgumentException;

class ContentNegotiator
{
    protected $handler;

    protected $router;

    /**
     * Create a new filter instance.
     *
     * @param  \Bonoize\RouterHelper  $router
     *
     * @return void
     */
    public function __construct(RouterHelper $router, Handler $handler)
    {
        $this->router  = $router;
        $this->handler = $handler;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->handler->hasHandler($this->router->getExtension() . 'Handler') ?
            $this->handler->handle($response) :
            $response;
    }
}
