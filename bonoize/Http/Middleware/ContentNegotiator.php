<?php namespace Bonoize\Http\Middleware;

use Bonoize\Handler;
use Bonoize\Helpers\RouterHelper;
use Closure;
use InvalidArgumentException;

class ContentNegotiator
{
    /**
     * Content handler implementation
     *
     * @var \Bonoize\Handler
     */
    protected $handler;

    /**
     * Router helper implementation
     *
     * @var \Bonoize\Helpers\RouterHelper
     */
    protected $router;

    /**
     * Create a new content negotiator instance.
     *
     * @param  \Bonoize\Helpers\RouterHelper $router
     * @param  \Bonoize\Handler              $handler
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
