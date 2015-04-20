<?php namespace Bonoize\Http\Controllers;

use Bonoize\Events\ControllerEvents;
use App\Http\Controllers\Controller;
use Bonoize\Transport;
use Event;

class BonoizeController extends Controller
{
    /**
     * Transport implementation
     *
     * @var \Bonoize\Transport
     */
    protected $transport;

    /**
     * Create a new controller instance.
     *
     * @var \Bonoize\DataTransport $transport
     *
     * @return void
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport->driver();
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $extension
     *
     * @return Response
     */
    public function index($extension = null)
    {
        $data  = $this->transport->index();
        $event = new ControllerEvents('afterIndex', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data  = $this->transport->create();
        $event = new ControllerEvents('afterCreate', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $extension
     *
     * @return Response
     */
    public function store($extension = null)
    {
        $input = app()->make('request')->all();
        $data  = $this->transport->store($extension, $input);
        $event = new ControllerEvents('afterStore', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @param string $extension
     *
     * @return Response
     */
    public function show($id, $extension = null)
    {
        $data  = $this->transport->show($id, $extension);
        $event = new ControllerEvents('afterShow', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data  = $this->transport->edit($id);
        $event = new ControllerEvents('afterEdit', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @param string $extension
     *
     * @return Response
     */
    public function update($id, $extension = null)
    {
        $input = app()->make('request')->all();
        $data  = $this->transport->update($id, $extension, $input);
        $event = new ControllerEvents('afterUpdate', $data);

        return last(event($event)) ?: null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param string $extension
     *
     * @return Response
     */
    public function destroy($id, $extension = null)
    {
        $data  = $this->transport->destroy($id, $extension);
        $event = new ControllerEvents('afterDestroy', $data);

        return last(event($event)) ?: null;
    }
}
