<?php namespace Bonoize\Handlers\Events;

use Bonoize\Events\ControllerEvents as Event;

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
        $this->router   = app()->make('Bonoize\RouterHelper');
    }

    /**
     * Handle the event.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    public function handle(Event $event)
    {
        return call_user_func_array([$this, $event->getMethod()], [$event]);
    }

    /**
     * Handle the event after controller invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function after(Event $event)
    {
        return view($this->template->getProperTemplate(), $event->getData());
    }

    /**
     * Handle the event after controller action @store() invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function afterStore(Event $event)
    {
        $data = $event->getData();

        $data['message'] = ucfirst($data['name']).' created';

        return redirect(route($data['name'].'.index'))->with($data);
    }

    /**
     * Handle the event after controller action @show() invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function afterShow(Event $event)
    {
        return $this->after($event);
    }

    /**
     * Handle the event after controller action @edit() invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function afterEdit(Event $event)
    {
        return $this->after($event);
    }

    /**
     * Handle the event after controller action @update() invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function afterUpdate(Event $event)
    {
        $data = $event->getData();

        $data['message'] = ucfirst($data['name']).' updated';

        $id = $this->router->getParameter('id');

        return redirect(route($data['name'].'.edit', $id))->with($data);
    }

    /**
     * Handle the event after controller action @destroy() invoked.
     *
     * @param Events $event
     *
     * @return \Iluminate\Http\Response
     */
    private function afterDestroy(Event $event)
    {
        $data = $event->getData();

        $data['message'] = ucfirst($data['name']).' deleted';

        return redirect(route($data['name'].'.index'))->with($data);
    }

    /**
     * Magic call to invoke after{Controller@action}
     *
     * @param string $method    Controller action method name
     * @param array  $arguments
     *
     * @return \Iluminate\Http\Response
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this, 'after'], $arguments);
    }
}
