<?php namespace App\Handlers\Events;

use App\Events\Event;

class ControllerEventsHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        $this->template = app()->make('Bonoize\Template');
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $method = $event->method;

        return call_user_func_array([$this, $event->method], [$event]);
    }

    private function after(Event $event)
    {
        return view($this->template->getProperTemplate(), $event->data);
    }
}
