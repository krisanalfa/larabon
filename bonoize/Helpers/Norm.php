<?php namespace Bonoize\Helpers;

class Norm
{
    /**
     * Get implementation of Eloquent Model
     *
     * @param  string $name Resource Name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEloquentInstance($name)
    {
        $Model = null;
        $model = null;

        if (class_exists('App\\' . studly_case($name))) {
            $Model = 'App\\' . studly_case($name);
            $model = new $Model;
        } else {
            $Model = 'Bonoize\Model\Base';
            $model = new $Model;

            $model->setTable($name);
        }

        return $model;
    }

    /**
     * Get schema configuration
     *
     * @param  string $name Resource name
     *
     * @return array
     */
    public function getSchemas($name)
    {
        return config('bonoize.schemas.' . $name, []);
    }
}
