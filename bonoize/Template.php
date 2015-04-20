<?php namespace Bonoize;

use Illuminate\View\Factory as View;
use Bonoize\Helpers\RouterHelper;

class Template
{
    /**
     * RouterHelper for easy access
     *
     * @var \Bonoize\Helpers\RouterHelper
     */
    protected $router;

    /**
     * Laravel View Factory implementation
     *
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * Initialization
     *
     * @param \Bonoize\Helpers\RouterHelper    $router
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(RouterHelper $router, View $view)
    {
        $this->router = $router;
        $this->view   = $view;
    }

    /**
     * Get proper template for current action
     *
     * @return string
     */
    public function getProperTemplate()
    {
        $template = $this->router->getRouteName();
        $action   = last((explode('.', $template)));

        return ($this->view->exists($template)) ? $template : "shared.{$action}";
    }
}
