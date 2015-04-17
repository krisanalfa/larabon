<?php namespace Bonoize\Schemas;

use Bonoize\Schema;

class Password extends Schema
{
    /**
     * Prepare data before saving
     *
     * @param string $value
     *
     * @return string
     */
    public function prepare($value)
    {
        return app()->make('hash')->make($value);
    }
}
