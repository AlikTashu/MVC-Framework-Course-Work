<?php

namespace vendor\core\base;


class Controller
{
    public $route;
    public $view;
    public $layout;
    public $vars;
    public $_MVCParams = [];
    public $isAjax = false;


    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route->getAction();
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        if(!$this->isAjax){
            $vObj->render($this->vars);
        }
    }

    public function set($vars)
    {
        $this->vars = $vars;
    }

}