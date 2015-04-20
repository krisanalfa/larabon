<?php namespace Bonoize\Handlers\Contents;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class JsonHandler
{
    /**
     * Extension name, to determine which attribute from data transport we use to serve
     *
     * @var string
     */
    protected $extension = 'json';

    /**
     * Handle specific extension
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return mixed
     */
    public function handle($response)
    {
        $extension = $this->extension;

        if ($response instanceof RedirectResponse) {
            return $response->getSession()->get($extension);
        } elseif ($response instanceof Response) {
            $content = $response->getOriginalContent();

            return $content[$extension];
        }
    }
}
