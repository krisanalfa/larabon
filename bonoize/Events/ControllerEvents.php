<?php namespace Bonoize\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ControllerEvents extends Event
{
    use SerializesModels;

    protected $attributes = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($method, array $data)
    {
        $this->attributes['data']   = $data;
        $this->attributes['method'] = $method;
    }

    /**
     * Get attribute value
     *
     * @param mixed $key
     *
     * @return mixed
     */
    private function get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function __call($method, $arguments)
    {
        $key = last(explode('get_', snake_case($method)));

        return call_user_func_array([$this, 'get'], [$key]);
    }
}
