<?php namespace Bonoize;

class DataTransport
{
    protected $normify;

    protected $router;

    protected $schemas = [];

    protected $resourceName;

    protected $routeName;

    protected $eloquentInstance;

    protected $data = [];

    public function __construct(Normify $normify, RouterHelper $router)
    {
        $this->normify          = $normify;
        $this->router           = $router;

        // Basic data information
        $this->resourceName     = $router->getResourceName();
        $this->schemas          = $normify->getSchemas($this->resourceName);
        $this->routeName        = $router->getRouteName();
        $this->eloquentInstance = $this->normify->getEloquentInstance($this->resourceName);
    }

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getData($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setData($key, $value);
        }
    }

    public function index()
    {
        $collection = $this->eloquentInstance->all();

        $this->prepareCommonData([
            'collection' => $collection,
            'json'       => $collection,
        ]);

        return $this->getData();
    }

    public function create()
    {
        $eloquent = $this->eloquentInstance;

        $this->prepareCommonData([
            'model'   => new $eloquent,
            'schemas' => $this->schemas,
        ]);

        return $this->getData();
    }

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
            'status' => 'success',
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    public function show($id, $extension = null)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        $this->prepareCommonData([
            'model'     => $model,
            'json'      => $model,
        ]);

        return $this->getData();
    }

    public function edit($id)
    {
        $this->prepareCommonData([
            'model'   => $this->eloquentInstance->findOrFail($id),
            'schemas' => $this->schemas,
        ]);

        return $this->getData();
    }

    public function update($id, $extension = null, array $data)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        foreach ($this->schemas as $field => $schema) {
            $model->$field = $schema->prepare($data[$field]);
        }

        $model->save();

        $this->prepareCommonData([
            'status' => 'success',
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    public function destroy($id, $extension = null)
    {
        $model = $this->eloquentInstance->findOrFail($id);

        $model->delete();

        $this->prepareCommonData([
            'status' => 'success',
            'model'  => $model,
            'json'   => $model,
        ]);

        return $this->getData();
    }

    private function prepareCommonData($additionalData = [])
    {
        $this->fill(array_merge([
            'name'       => $this->resourceName,
            'routeName'  => $this->routeName,
            'schemas'    => array_except($this->schemas, $this->eloquentInstance->getHidden()),
        ], $additionalData));
    }

    public function __get($key)
    {
        return $this->getData($key);
    }

    public function __set($key, $value)
    {
        $this->setData($key, $value);
    }
}
