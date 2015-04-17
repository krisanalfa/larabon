<?php namespace Bonoize;

use Illuminate\View\Factory as View;

class Template
{
    protected $router;

    protected $view;

    public function __construct(RouterHelper $router, View $view)
    {
        $this->router = $router;
        $this->view   = $view;
    }

    public function getProperTemplate()
    {
        $template = $this->router->getRouteName();
        $action   = last((explode('.', $template)));

        return ($this->view->exists($template)) ? $template : "shared.{$action}";
    }
}
