<?php namespace Bonoize;

class Normify
{
    public function getEloquentInstance($name)
    {
        $Model = null;
        $model = null;

        if (class_exists('App\\' . studly_case($name))) {
            $Model = 'App\\' . studly_case($name);
            $model = new $Model;
        } else {
            $Model = 'Bonoize\Base';
            $model = new $Model;

            $model->setTable($name);
        }

        return $model;
    }

    public function getSchemas($name)
    {
        return config('bonoize.schemas.' . $name, []);
    }
}
