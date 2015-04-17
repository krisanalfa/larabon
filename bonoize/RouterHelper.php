<?php namespace Bonoize;

use Illuminate\Routing\Router;

class RouterHelper
{
    protected $router;

    protected $route;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->route  = $router->getCurrentRoute();
    }

    public function getResourceName()
    {
        return head((explode('.', $this->getRouteName())));
    }

    public function getRouteName()
    {
        return is_null($this->route) ? null: $this->route->getName();
    }

    public function hasExtension()
    {
        return str_contains(app()->make('request')->getPathInfo(), '.') and !empty($this->getExtension());
    }

    public function getExtension()
    {
        return last(explode('.', $this->route->getParameter('extension')));
    }

    public function getParameter($parameterName, $default = null)
    {
        return $this->route->getParameter($parameterName, $default);
    }

    public function route()
    {
        return $this->route;
    }

    public function router()
    {
        return $this->router;
    }
}
