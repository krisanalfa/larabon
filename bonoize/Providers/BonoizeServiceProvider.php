<?php namespace Bonoize\Providers;

use Bonoize\Http\Controllers\BonoizeController;
use Exception;
use Illuminate\Support\ServiceProvider;
use UnexpectedValueException;

class BonoizeServiceProvider extends ServiceProvider
{
    /**
     * Current configuration mapping
     *
     * @var array
     */
    protected $config = [];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $defaultController = config('bonoize.default');
        $mapping           = config('bonoize.mapping');

        if (is_null($mapping)) {
            return;
        }

        if (is_null($defaultController)) {
            throw new UnexpectedValueException('Bonoize doesn\'t have a default controller');
        }

        $this->app['router']->pattern('id', '^[0-9a-f]{24}$');
        $this->app['router']->pattern('extension', '\.[a-zA-Z]+');

        foreach ($mapping as $path => $config) {
            $this->config    = $config;
            $controller      = $this->getConfig('controller', $defaultController);
            $resourceName    = $this->getConfig('name');
            $middlewares     = $this->getConfig('middlewares', '');
            $serviceProvider = $this;

            if (is_null($resourceName)) {
                throw new Exception('Resource mapping configuration should has a "name"');
            }

            $this->app['router']->group(['middleware' => explode('|', $middlewares)], function () use (
                $serviceProvider, $path, $controller, $resourceName, $middlewares
            ) {
                $serviceProvider->registerRoute(['get'], $path, $controller, 'index', $resourceName, true);
                $serviceProvider->registerRoute(['get'], $path . '/create', $controller, 'create', $resourceName);
                $serviceProvider->registerRoute(['post'], $path, $controller, 'store', $resourceName, true);
                $serviceProvider->registerRoute(['get'], $path . '/{id}', $controller, 'show', $resourceName, true);
                $serviceProvider->registerRoute(['get'], $path . '/{id}/edit', $controller, 'edit', $resourceName);
                $serviceProvider->registerRoute(['put', 'patch'], $path . '/{id}', $controller, 'update', $resourceName, true);
                $serviceProvider->registerRoute(['delete'], $path . '/{id}', $controller, 'destroy', $resourceName, true);
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Bonoize\Http\Requests\CriteriaParser', 'Bonoize\Http\Requests\CriteriaParser');
    }

    /**
     * Register the route
     *
     * @param  array   $via          Accepted method for your route
     * @param  string  $path         Virtual ath to access your route
     * @param  string  $controller   The controller name to handle your request
     * @param  string  $action       The action in your controller to handle your request
     * @param  string  $name         The name of your route
     * @param  boolean $hasExtension Does your route has extension?
     *
     * @return void
     */
    protected function registerRoute(array $via, $path, $controller, $action, $name, $hasExtension = false)
    {
        if ($hasExtension === true) {
            $path = $path . '{extension?}';
        }

        $this->app['router']->match($via, $path, [
            'uses' => $controller . '@' . $action,
            'as'   => $name . '.' . $action,
        ]);
    }

    /**
     * Get specific configuration
     *
     * @param string $key     Key stored in configuration
     * @param mixed  $default Default value if configuration not found
     *
     * @return mixed
     */
    protected function getConfig($key, $default = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }
}
