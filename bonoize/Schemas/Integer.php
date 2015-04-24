<?php namespace Bonoize\Schemas;

use Bonoize\Schema;

class Integer extends Schema
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
