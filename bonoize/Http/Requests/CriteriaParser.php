<?php namespace Bonoize\Http\Requests;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class CriteriaParser extends Collection
{
    /**
     * Get an item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = [])
    {
        if ($this->offsetExists($key))
        {
            return $this->items[$key];
        }

        return value($default);
    }

    public function parseCriteria(Request $request)
    {
        $criteria = array_where($request->query(), function ($index, $item) {
            return $index[0] !== '!';
        });

        $this->put('criteria', $criteria);
    }

    public function parseCommand(Request $request)
    {
        $command = array_where($request->query(), function ($index, $item) {
            return $index[0] === '!';
        });

        $this->put('command', $command);
    }

    public function getOr()
    {
        $return       = $this->getCommand('!or');
        $orExpression = [];

        foreach ($return as $field => $value) {
            $exploded = explode(':', $value);

            if (count($exploded) === 1) {
                array_unshift($exploded, '!eq');
            }

            $orExpression[] = [
                $field,
                $this->subtituteExpression($exploded[0]),
                $exploded[1]
            ];
        }

        return $orExpression;
    }

    public function getLessThan()
    {
        return $this->getCommand('!lt');
    }

    public function getLessThanOrEqual()
    {
        return $this->getCommand('!lte');
    }

    public function getGreaterThan()
    {
        return $this->getCommand('!gt');
    }

    public function getGreaterThanOrEqual()
    {
        return $this->getCommand('!gte');
    }

    public function getCommand($command)
    {
        $commands = $this->get('command');

        if (! $commands) {
            return [];
        }

        if (is_array($commands)) {
            $return = isset($commands[$command]) ? $commands[$command] : array();

            return $return;
        }
    }

    protected function subtituteExpression($expresion)
    {
        $return = '';

        switch ($expresion) {
            case '!lt':
                $return = '<';
                break;
            case '!lte':
                $return = '<=';
                break;
            case '!gt':
                $return = '>';
                break;
            case '!gte':
                $return = '>=';
                break;
            default:
                $return = '=';
                break;
        }

        return $return;
    }
}
