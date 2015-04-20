<?php namespace Bonoize;

abstract class Schema
{
    /**
     * Render plain format
     *
     * @param  mixed $value
     *
     * @return mixed
     */
    public function formatPlain($value)
    {
        return $value;
    }

    /**
     * Render for input purpose
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return \Illuminate\View\Factory
     */
    public function formatInput($name, $value)
    {
        return view('schemas.rw.'.$this->getName(), [
            'value' => $value,
            'name' => $name,
        ]);
    }

    /**
     * Render for read only
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return \Illuminate\View\Factory
     */
    public function formatReadOnly($name, $value)
    {
        return view('schemas.ro.'.$this->getName(), [
            'value' => $value,
            'name' => $name,
        ]);
    }

    /**
     * Prepare the value before we save it to database
     *
     * @param  [type] $value [description]
     *
     * @return [type]        [description]
     */
    public function prepare($value)
    {
        return $value;
    }

    /**
     * Get the name of the schema
     *
     * @return string
     */
    protected function getName()
    {
        return strtolower(last(explode('\\', get_class($this))));
    }
}
