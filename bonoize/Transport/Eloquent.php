<?php namespace Bonoize\Transport;

use Bonoize\Helpers\Norm;
use Bonoize\Helpers\RouterHelper;

class Eloquent
{
    /**
     * Bootstrap Alert Context for Success
     */
    const SUCESS  = 'success';

    /**
     * Bootstrap Alert Context for Info
     */
    const INFO    = 'info';

    /**
     * Bootstrap Alert Context for Danger
     */
    const DANGER  = 'danger';

    /**
     * Bootstrap Alert Context for Warning
     */
    const WARNING = 'warning';

    /**
     * Bootstrap Alert Context for Error
     */
    const ERROR   = 'error';

    /**
     * Norm implementation
     *
     * @var \Bonoize\Helpers\Norm
     */
    protected $norm;

    /**
     * RouterHelper implementation
     *
     * @var \Bonoize\Helpers\RouterHelper
     */
    protected $router;

    /**
     * Schemas configuration
     *
     * @var array
     */
    protected $schemas = [];

    /**
     * Resource name of current route
     *
     * @var string
     */
    protected $resourceName;

    /**
     * Route name of current route
     *
     * @var string
     */
    protected $routeName;

    /**
     * Eloquent implementation
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $eloquentInstance;

    /**
     * Data for current controller
     *
     * @var array
     */
    protected $data = [];

    /**
     * Initialize Data Transport
     *
     * @param \Bonoize\Helpers\Norm             $norm
     * @param \Bonoize\Helpers\RouterHelper $router
     */
    public function __construct(Norm $norm, RouterHelper $router)
    {
        $this->norm   = $norm;
        $this->router = $router;

        // Basic data information
        $this->resourceName     = $router->getResourceName();
        $this->schemas          = $norm->getSchemas($this->resourceName);
        $this->routeName        = $router->getRouteName();
        $this->eloquentInstance = $this->norm->getEloquentInstance($this->resourceName);
    }

    /**
     * Set data
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Get data
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getData($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }

    /**
     * Same as setData, but this is mass asignment using array
     *
     * @param  array  $data
     *
     * @return void
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setData($key, $value);
        }
    }

    /**
     * Get data for action index
     *
     * @return array
     */
    public function index()
    {
        $collection = $this->eloquentInstance->all();

        $this->prepareCommonData([
            'collection' => $collection,
            'json'       => $collection,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action create
     *
     * @return array
     */
    public function create()
    {
        $eloquent = $this->eloquentInstance;

        $this->prepareCommonData([
            'model'   => new $eloquent,
            'schemas' => $this->schemas,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action store
     *
     * @param string $extension
     * @param array  $data
     *
     * @return array
     */
    public function store($extension = null, array $data)
    {
        $name     = $this->resourceName;
        $eloquent = $this->eloquentInstance;
        $model    = new $eloquent;

        foreach ($this->schemas as $field => $schema) {
            $model->$field = $schema->prepare($data[$field]);
        }

        $model->save();

        $this->prepareCommonData([
            'status' => DataTransport::SUCESS,
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action show
     *
     * @param  string $id
     * @param  string $extension
     *
     * @return array
     */
    public function show($id, $extension = null)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        $this->prepareCommonData([
            'model'     => $model,
            'json'      => $model,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action edit
     *
     * @param  string $id
     *
     * @return array
     */
    public function edit($id)
    {
        $this->prepareCommonData([
            'model'   => $this->eloquentInstance->findOrFail($id),
            'schemas' => $this->schemas,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action update
     *
     * @param  string $id
     * @param  string $extension
     * @param  array  $data
     *
     * @return array
     */
    public function update($id, $extension = null, array $data)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        foreach ($this->schemas as $field => $schema) {
            $model->$field = $schema->prepare($data[$field]);
        }

        $model->save();

        $this->prepareCommonData([
            'status' => DataTransport::SUCESS,
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    /**
     * Get data for action destroy
     *
     * @param  string $id
     * @param  string $extension
     *
     * @return array
     */
    public function destroy($id, $extension = null)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        $model->delete();

        $this->prepareCommonData([
            'status' => DataTransport::SUCESS,
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    /**
     * Prepare common data for response
     *
     * @param  array $additionalData
     *
     * @return string
     */
    protected function prepareCommonData(array $additionalData = [])
    {
        $this->fill(array_merge([
            'name'       => $this->resourceName,
            'routeName'  => $this->routeName,
            'schemas'    => array_except($this->schemas, $this->eloquentInstance->getHidden()),
        ], $additionalData));
    }

    /**
     * Get the data from attributes
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getData($key);
    }

    /**
     * Set the data from attributes
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        $this->setData($key, $value);
    }
}
