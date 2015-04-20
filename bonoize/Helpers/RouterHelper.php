<?php namespace Bonoize\Helpers;

use Illuminate\Routing\Router;

class RouterHelper
{
    /**
     * Router implementation
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Current route
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
     * Initialize
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->route  = $router->getCurrentRoute();
    }

    /**
     * Get resource name
     *
     * @return string
     */
    public function getResourceName()
    {
        return head((explode('.', $this->getRouteName())));
    }

    /**
     * Get current route name
     *
     * @return string
     */
    public function getRouteName()
    {
        return is_null($this->route) ? null: $this->route->getName();
    }

    /**
     * Determine if current request has an extension
     *
     * @return boolean
     */
    public function hasExtension()
    {
        return str_contains(app()->make('request')->getPathInfo(), '.') and !empty($this->getExtension());
    }

    /**
     * Get the extension of current request
     *
     * @return string
     */
    public function getExtension()
    {
        return preg_replace('/^\./', '', $this->route->getParameter('extension'));
    }

    /**
     * Get parameter of current route
     *
     * @param  string $parameterName
     * @param  mixed  $default
     *
     * @return string
     */
    public function getParameter($parameterName, $default = null)
    {
        return $this->route->getParameter($parameterName, $default);
    }

    /**
     * Get current route
     *
     * @return \Illuminate\Routing\Route
     */
    public function route()
    {
        return $this->route;
    }

    /**
     * Get the router
     *
     * @return \Illuminate\Routing\Router
     */
    public function router()
    {
        return $this->router;
    }
}
