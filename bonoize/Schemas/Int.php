<?php namespace Bonoize\Schemas;

use Bonoize\Schema;

class Int extends Schema
{
    /**
     * Render plain format
     *
     * @param  mixed $value
     *
     * @return int
     */
    public function formatPlain($value)
    {
        return (int) $value;
    }
}
