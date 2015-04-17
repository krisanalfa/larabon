<?php namespace Bonoize;

abstract class Schema
{
    public function formatPlain($value)
    {
        return $value;
    }

    public function formatInput($name, $value)
    {
        return view('schemas.rw.'.$this->getName(), [
            'value' => $value,
            'name' => $name,
        ]);
    }

    public function formatReadOnly($name, $value)
    {
        return view('schemas.ro.'.$this->getName(), [
            'value' => $value,
            'name' => $name,
        ]);
    }

    public function prepare($value)
    {
        return $value;
    }

    private function getName()
    {
        return strtolower(last(explode('\\', get_class($this))));
    }
}
