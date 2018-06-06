<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 27.05.2018
 * Time: 11:40
 */

namespace vendor\core\router;

use vendor\core\base\IFilter;
use vendor\core\exception\BadUrlException;

class Route
{
    private $uri;
    private $controller;
    private $action;
    private $alternativeDefaultRoute;
    private $filters = [];


    public function __construct($uri, $controller = "home", $action = "index")
    {
        $this->uri = $uri;
        $this->controller = $controller;
        $this->action = $action;
        $this->alternativeDefaultRoute = strtolower($controller . "/" . $action);
    }

    public function checkFilters()
    {
        #println("in checkFilters", "blue");
        foreach ($this->filters as $filter) {
            if ($filter->check($this)) {
                $filter->callback();
            }
        }
    }

    public function registerFilter(IFilter $filter)
    {
        array_push($this->filters, $filter);
        return $this;
    }

    public function matchRoute($uri, &$params)
    {
        $pattern = "|^(?P<query>" . $this->uri . ")(/.+)?$|";
        preg_match($pattern, $uri, $matches);
        if (isset($matches['query'])) {
            $query = $matches['query'];
            if ($query === $this->uri) {
                if (array_key_exists('2', $matches)) {
                    $params = explode('/', $matches[2]);
                    array_shift($params);
                }
                return true;
            }
        }
        return false;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAlternativeDefaultRoute()
    {
        return $this->alternativeDefaultRoute;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}
