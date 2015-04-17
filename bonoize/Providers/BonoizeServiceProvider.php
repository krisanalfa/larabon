<?php namespace Bonoize\Providers;

use Bonoize\Http\Controllers\BonoizeController;
use Exception;
use Illuminate\Support\ServiceProvider;
use UnexpectedValueException;

class BonoizeServiceProvider extends ServiceProvider
{
    protected $config = [];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $defaultController = config('bonoize.default');
        $mapping           = config('bonoize.mapping', []);

        if (empty($mapping)) {
            return;
        }

        if (is_null($defaultController)) {
            throw new UnexpectedValueException('Bonoize doesn\'t have a default controller');
        }

        $this->app['router']->pattern('id', '^[0-9a-f]{24}$');
        $this->app['router']->pattern('extension', '\.[a-z]+');

        foreach ($mapping as $path => $config) {
            $this->config = $config;
            $resourceName = str_replace('/', '', $path);
            $controller   = $this->getConfig('controller', $defaultController);
            $name         = $this->getConfig('name');
            $middlewares  = $this->getConfig('middlewares', '');
            $me           = $this;

            $this->app['router']->group(['middleware' => explode('|', $middlewares)], function () use (
                $me, $path, $controller, $name, $middlewares
            ) {
                $me->registerRoute(['get'], $path, $controller, 'index', $name, true);
                $me->registerRoute(['get'], $path . '/create', $controller, 'create', $name);
                $me->registerRoute(['post'], $path, $controller, 'store', $name, true);
                $me->registerRoute(['get'], $path . '/{id}', $controller, 'show', $name, true);
                $me->registerRoute(['get'], $path . '/{id}/edit', $controller, 'edit', $name);
                $me->registerRoute(['put', 'patch'], $path . '/{id}', $controller, 'update', $name, true);
                $me->registerRoute(['delete'], $path . '/{id}', $controller, 'destroy', $name, true);
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
    }

    private function registerRoute(array $via, $path, $controller, $action, $name, $hasExtension = false)
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
    private function getConfig($key, $default = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }
}
