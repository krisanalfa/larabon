<?php namespace Bonoize;

use Illuminate\Container\Container;
use Illuminate\Support\Manager;

class Transport extends Manager
{
    /**
     * Aplication implementation
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Initialize the Transport
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
        return config('bonoize.transport.default', 'eloquent');
    }

    /**
     * Create JSON Handler Driver
     *
     * @return \Bonoize\DataTransport
     */
    protected function createEloquentDriver()
    {
        return app()->make('Bonoize\Transport\Eloquent');
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
