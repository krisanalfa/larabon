<?php namespace Bonoize;

use Illuminate\Container\Container;
use Illuminate\Support\Manager;

class Handler extends Manager
{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function getDefaultDriver()
    {
        return 'jsonHandler';
    }

    protected function createJsonHandlerDriver()
    {
        return $this->app['Bonoize\Handlers\Contents\JsonHandler'];
    }

    public function hasHandler($driver)
    {
        $method = 'create' . ucfirst($driver) . 'Driver';

        if (isset($this->customCreators[$driver])) {
            return true;
        } elseif (method_exists($this, $method)) {
            return true;
        }

        return false;
    }
}
