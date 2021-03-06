<?php namespace Bonoize;

use Illuminate\Container\Container;
use Illuminate\Support\Manager;

class Handler extends Manager
{
    /**
     * Aplication implementation
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Initialize the Handler
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Get default handler
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'jsonHandler';
    }

    /**
     * Create JSON Handler Driver
     *
     * @return \Bonoize\Handlers\Contents\JsonHandler
     */
    protected function createJsonHandlerDriver()
    {
        return $this->app['Bonoize\Handlers\Contents\JsonHandler'];
    }

    /**
     * Determine if the manager has the given handler
     *
     * @param  string  $driver
     *
     * @return boolean
     */
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
